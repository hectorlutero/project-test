<?php

namespace App\Http\Controllers\Partner;


use App\Services\CompanyService;
use App\Services\ServiceService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class BusinessController extends Controller
{
    protected ServiceService $service;
    protected CompanyService $company;

    function __construct(ServiceService $service, CompanyService $company)
    {
        $this->middleware(['role_or_permission:client|business-list']);
        $this->service = $service;
        $this->company = $company;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];



        try {
            $companyOrder = $request->company_order ?? "desc";
            $companyStatusFilter = $request->filter ?? 'pending_approval|active';

            $entries['filtersMenu']['companies'] = [
                [
                    'checked' => str_contains($companyStatusFilter, 'pending_approval'),
                    'value' => 'pending_approval',
                    'title' => "Pendente Aprovação"
                ],
                [
                    'checked' => str_contains($companyStatusFilter, 'active'),
                    'value' => 'active',
                    'title' => "Ativos"
                ],
                [
                    'checked' => str_contains($companyStatusFilter, 'banned'),
                    'value' => 'banned',
                    'title' => "Banidos/Desativados"
                ]
            ];

            $companiesCheckedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu']['companies'], function ($arr) {
                return $arr['checked'] == true;
            }));
            $companiesList = $this->company->filterCompanyFieldInArray('status', $companiesCheckedOptions, 25, 'id', $companyOrder, auth()->id())->appends(['order' => $companyOrder]);
            $entries['checkedOptions']['companies'] = join("|", $companiesCheckedOptions);
            foreach ($companiesList as $company) {
                if (isset($company->logo_id)) {
                    $logo = $this->showMedia($company->logo_id);
                    if ($logo)
                        $company->logo = $logo->file_location;

                }
            }
            $entries['list']['companies'] = $companiesList;
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.partners.business')
            ->with(['entries' => $entries]);
    }

    public function search(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $statusFilter = $request->filter;

        try {

            $companyOrder = $request->company_order ?? "desc";
            $companyStatusFilter = $request->filter ?? 'pending_approval|active';

            $entries['filtersMenu']['companies'] = [
                [
                    'checked' => str_contains($companyStatusFilter, 'pending_approval'),
                    'value' => 'pending_approval',
                    'title' => "Pendente Aprovação"
                ],
                [
                    'checked' => str_contains($companyStatusFilter, 'active'),
                    'value' => 'active',
                    'title' => "Ativos"
                ],
                [
                    'checked' => str_contains($companyStatusFilter, 'banned'),
                    'value' => 'banned',
                    'title' => "Banidos/Desativados"
                ]
            ];

            $companiesCheckedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu']['companies'], function ($arr) {
                return $arr['checked'] == true;
            }));
            // dd($checkedOptions);
            if (empty($companiesCheckedOptions)) {
                $companiesCheckedOptions = [0 => 'pending_approval', 1 => 'active', 2 => 'banned'];
            }
            $companiesList = $this->company->getFiltered($request->except(['_token']), 25, auth()->id());


            $entries['checkedOptions']['companies'] = join("|", $companiesCheckedOptions);
            foreach ($companiesList as $company) {
                if (isset($company->logo_id)) {
                    $logo = $this->showMedia($company->logo_id);
                    if ($logo)
                        $company->logo = $logo->file_location;

                }
            }
            $entries['list']['companies'] = $companiesList;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }
        return view('pages.partners.business')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando empresa";
        } else {
            $result['entry'] = $this->company->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
            $logo = $this->showMedia($result['entry']->logo_id);
            if ($logo)
                $result['logo'] = $logo->file_location;
        }

        try {
            $form = $this->company->getFields();
            $result['fields'] = $form['fields'];
            $result['js'] = $form['js'];
            $result['action'] = "/partner/business/" . $result['entry']->id;
            $result['model'] = "partner.businesses";
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

            $company = $this->company->saveCompanyData($data, auth()->id());
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            dd($e->getMessage());
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('partner.businesses.index');
    }

    public function deleteEntry(Request $request)
    {

        try {
            $this->company->delete($request->id);

            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('partner.businesses.index');
    }

    public function deleteEntries(Request $request)
    {
        $companies = json_decode($request->values);
        $result = ['status' => 200];
        try {
            $result['data'] = [];
            foreach ($companies as $companyId) {
                $result['data'][] = $this->company->delete($companyId);
            }
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return true;
    }

    public function showMedia($id)
    {


        try {
            $media = $this->company->getMediaGallery($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return $media;
    }
    public function showGallery(Request $request)
    {
        $entries = [
            'status' => 200,
            'type_plural' => 'businesses',
            'type_singular' => 'business',
            'id' => $request->id
        ];
        $order = $request->order ?? "desc";

        try {
            $list = $this->company->getGallery($entries['id'], 25);
            $entries['list'] = $list;
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.partners.gallery')
            ->with(['entries' => $entries]);
    }


    public function updateMedia(Request $request)
    {
        $id = $request->id;
        $data = $request->except([
            '_token'
        ]);
        try {
            $data['id'] = $id;
            $company = $this->company->saveMediaData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }
        // $url = route('partner.gallery', ['id' => $id]);

        return back();
    }

    public function deleteMedia(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->company->deleteMedia($request->id);
            try {
                Flasher::addPreset("entity_deleted");
            } catch (\Throwable $th) {
                //throw $th;
                dd('Controller =>', $th);
            }
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->back();
    }

}