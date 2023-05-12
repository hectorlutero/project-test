<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $filter = $request->filter;
        $fields = $this->companyService->getFields()['model_attributes'];
        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($filter, 'pending_approval'),
                    'value' => 'pending_approval',
                    'option' => 'pending_approval',
                    'field' => 'status',
                    'title' => "Pendente Aprovação"
                ],
                [
                    'checked' => str_contains($filter, 'active'),
                    'value' => 'active',
                    'option' => 'active',
                    'field' => 'status',
                    'title' => "Ativos"
                ],
                [
                    'checked' => str_contains($filter, 'banned'),
                    'value' => 'banned',
                    'option' => 'banned',
                    'field' => 'status',
                    'title' => "Banidos/Desativados"
                ],
                [
                    'checked' => str_contains($filter, 'free'),
                    'value' => 'free',
                    'field' => 'plan_id',
                    'title' => "Plano Free"
                ],
                [
                    'checked' => str_contains($filter, 'premium'),
                    'value' => 'premium',
                    'field' => 'plan_id',
                    'title' => "Plano Premium"
                ],
                [
                    'checked' => str_contains($filter, 'ondemand'),
                    'value' => 'ondemand',
                    'field' => 'plan_id',
                    'title' => "Plano OnDemand"
                ],

            ];



            $checkedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu'], function ($arr) {
                return $arr['checked'] == true;
            }));
            $checkedValues = array_map(function ($arrMap) {
                return $arrMap['name'];
            }, array_filter($entries['filtersMenu'], function ($arr) {
                return $arr['checked'] == true;
            }));


            if (empty($checkedOptions)) {
                $checkedOptions = [0 => 'pending_approval', 1 => 'active', 2 => 'banned'];
            }

            $list = $this->companyService->filterCompanyFieldInArray($checkedValues, $checkedOptions, 25, 'id', $order, auth()->id())->appends(['order' => $order]);

            $entries['checkedOptions'] = join("|", $checkedOptions);
            foreach ($list as $company) {
                if (isset($company->logo_id)) {
                    $logo = $this->showMedia($company->logo_id);
                    if ($logo)
                        $company->logo = $logo->file_location;

                }
            }
            $entries['list'] = $list;
            $entries['fields'] = $fields;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }
        return view('pages.admin.partners.companies')
            ->with(['entries' => $entries]);
    }

    public function search(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $statusFilter = $request->filter;

        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($statusFilter, 'pending_approval'),
                    'value' => 'pending_approval',
                    'title' => "Pendente Aprovação"
                ],
                [
                    'checked' => str_contains($statusFilter, 'active'),
                    'value' => 'active',
                    'title' => "Ativos"
                ],
                [
                    'checked' => str_contains($statusFilter, 'banned'),
                    'value' => 'banned',
                    'title' => "Banidos/Desativados"
                ]
            ];

            $checkedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu'], function ($arr) {
                return $arr['checked'] == true;
            }));
            // dd($checkedOptions);
            if (empty($checkedOptions)) {
                $checkedOptions = [0 => 'pending_approval', 1 => 'active', 2 => 'banned'];
            }
            $list = $this->companyService->getFiltered($request->except(['_token']), 25);


            $entries['checkedOptions'] = join("|", $checkedOptions);
            foreach ($list as $company) {
                if (isset($company->logo_id)) {
                    $logo = $this->showMedia($company->logo_id);
                    if ($logo)
                        $company->logo = $logo->file_location;

                }
            }
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }
        return view('pages.admin.partners.companies')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando empresa";
        } else {
            $result['entry'] = $this->companyService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
            $logo = $this->showMedia($result['entry']->logo_id);
            if ($logo)
                $result['logo'] = $logo->file_location;
        }

        try {

            $form = $this->companyService->getFields();
            $result['fields'] = $form['fields'];
            $result['js'] = $form['js'];
            $result['action'] = "/admin/company/" . $result['entry']->id;
            $result['model'] = "admin.companies";

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return view('helpers.form-builder')
            ->with(['form' => $result]);
    }

    public function updateEntry(Request $request)
    {
        $id = $request->id;
        $data = $request->except([
            '_token'
        ]);

        try {
            $data['id'] = $id;
            $company = $this->companyService->saveCompanyData($data, null);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.companies.index');
    }

    public function updateEntries(Request $request)
    {
        $companies = json_decode($request->values);
        $data = $request->except([
            '_token',
            'values',
            'type'
        ]);
        try {
            foreach ($companies as $companyId) {
                $data['id'] = $companyId;
                $data['status'] = $request->status;
                $company = $this->companyService->saveCompanyData($data);
            }
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.companies.index');

    }

    public function importEntries(Request $request)
    {
        // TODO: Implement IMPORT FOR COMPANIES
        return;
    }
    public function deleteEntry(Request $request)
    {

        try {
            $this->companyService->delete($request->id);

            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.companies.index');
    }

    public function deleteEntries(Request $request)
    {
        $companies = json_decode($request->values);
        $result = ['status' => 200];
        try {
            $result['data'] = [];
            foreach ($companies as $companyId) {
                $result['data'][] = $this->companyService->delete($companyId);
            }
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return true;
    }


    public function manageBan(Request $request)
    {

        try {
            $this->companyService->manageBan($request->id);
            Flasher::addPreset("entity_status_changed");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_status_changed_error");
        }

        return redirect()->back();
    }
    public function showMedia($id)
    {


        try {
            $media = $this->companyService->getMediaGallery($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return $media;
    }
}