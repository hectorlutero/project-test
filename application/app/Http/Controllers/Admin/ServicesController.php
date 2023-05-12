<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use App\Services\CompanyService;
use App\Services\ImportSpreadsheetService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    protected ServiceService $serviceService;
    protected CompanyService $companyService;
    protected ImportSpreadsheetService $importSpreadsheetService;


    public function __construct(
        ServiceService $serviceService,
        CompanyService $companyService,
        ImportSpreadsheetService $importSpreadsheetService
    ) {
        $this->serviceService = $serviceService;
        $this->companyService = $companyService;
        $this->importSpreadsheetService = $importSpreadsheetService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $filter = $request->filter ?? 'DRAFT';

        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($filter, 'DRAFT'),
                    'value' => 'DRAFT',
                    'title' => "Pendente Aprovação"
                ],
                [
                    'checked' => str_contains($filter, 'PUBLISHED'),
                    'value' => 'PUBLISHED',
                    'title' => "Publicado"
                ]
            ];

            $checkedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu'], function ($arr) {
                return $arr['checked'] == true;
            }));
            $list = $this->serviceService->filterServiceFieldInArray('status', $checkedOptions, 25, 'id', $order, null, null)->appends(['order' => $order]);

            foreach ($list as $service) {
                $gallery = $this->serviceService->getGallery($service->id, 25);
                $service->image_count = count($gallery);
                $company = $this->companyService->getById($service->company_id);
                $service->company_name = $company->name;
                $service->company_id = $company->id;
            }
            $entries['checkedOptions'] = join("|", $checkedOptions);
            $entries['companies'] = $this->companyService->getAll(100);
            $entries['list'] = $list;
            $entries['type'] = 'service';


        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.services')
            ->with(['entries' => $entries]);
    }

    public function search(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $statusFilter = $request->filter ?? 'DRAFT';

        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($statusFilter, 'DRAFT'),
                    'value' => 'DRAFT',
                    'title' => "Rascunho"
                ],
                [
                    'checked' => str_contains($statusFilter, 'PUBLISHED'),
                    'value' => 'PUBLISHED',
                    'title' => "Publicados"
                ]
            ];

            $checkedOptions = array_map(function ($arrMap) {
                return $arrMap['value'];
            }, array_filter($entries['filtersMenu'], function ($arr) {
                return $arr['checked'] == true;
            }));
            if (empty($checkedOptions)) {
                $checkedOptions = [0 => 'DRAFT', 1 => 'PUBLISHED'];
            }
            $list = $this->serviceService->getFiltered($request->except(['_token']), 25);
            foreach ($list as $service) {

                $gallery = $this->serviceService->getGallery($service->id, 25);
                $service->image_count = count($gallery);
                $company = $this->companyService->getById($service->company_id);
                $service->company_name = $company->name;
                $service->company_slug = $company->slug;
                $service->company_id = $company->id;
            }

            $entries['checkedOptions'] = join("|", $checkedOptions);
            $entries['list'] = $list;
            $entries['companies'] = $this->companyService->getAll(100);
            $entries['type'] = 'service';

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.services')
            ->with(['entries' => $entries]);
    }


    public function exportModel(Request $request)
    {

        try {
            $service = $this->importSpreadsheetService->downloadModel('service');
            // Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return $service;
    }


    public function importEntries(Request $request)
    {
        $data = $request->except([
            '_token'
        ]);
        $data['type'] = 'service';
        try {
            $service = $this->serviceService->importServiceData($data);
            if ($service['status'] === "success")
                flash()->addSuccess($service['msg']);
            else if ($service['status'] === "warning")
                flash()->addWarning($service['msg']);
            else
                flash()->addError($service['msg']);

            // Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.services.index');
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando serviço";
        } else {
            $result['entry'] = $this->serviceService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {
            $form = $this->serviceService->getFields();
            $result['fields'] = $form['fields'];
            $result['js'] = $form['js'];
            $result['action'] = "/admin/service/" . $result['entry']->id;
            $result['model'] = "admin.services";

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
            $service = $this->serviceService->saveServiceData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error")->setMessage($e->getMessage());
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.services.index');
    }

    public function updateEntries(Request $request)
    {
        $services = json_decode($request->values);
        $data = $request->except([
            '_token',
            'values',
            'type'
        ]);
        try {
            foreach ($services as $serviceId) {
                $data['id'] = $serviceId;
                $data['status'] = $request->status;
                $service = $this->serviceService->saveServiceData($data);
            }
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.service.index');

    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->serviceService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.services.index');
    }

    public function deleteEntries(Request $request)
    {
        $services = json_decode($request->values);
        $result = ['status' => 200];
        try {
            $result['data'] = [];
            foreach ($services as $serviceId) {
                $result['data'][] = $this->serviceService->delete($serviceId);
            }
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return true;
    }


    public function showGallery(Request $request)
    {
        $entries = [
            'status' => 200,
            'type_plural' => 'services',
            'type_singular' => 'service',
            'id' => $request->id
        ];
        $order = $request->order ?? "desc";

        try {
            $list = $this->serviceService->getGallery($request->id, 25);
            $entries['list'] = $list;
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.gallery')
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
            $service = $this->serviceService->saveMediaData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }
        // $url = route('admin.products.gallery', ['id' => $id]);

        return back();
    }

    public function deleteMedia(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->serviceService->deleteMedia($request->id);
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