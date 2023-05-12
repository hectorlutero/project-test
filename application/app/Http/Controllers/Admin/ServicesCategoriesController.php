<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServiceCategoryService;
use App\Services\CompanyService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ServicesCategoriesController extends Controller
{
    protected ServiceCategoryService $serviceCategoryService;
    protected CompanyService $companyService;

    public function __construct(ServiceCategoryService $serviceCategoryService, CompanyService $companyService)
    {
        $this->serviceCategoryService = $serviceCategoryService;
        $this->companyService = $companyService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {

            $list = $this->serviceCategoryService->getAll(25);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.services-categories')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando categorias de serviço";
        } else {
            $result['entry'] = $this->serviceCategoryService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->serviceCategoryService->getFields()['fields'];
            $result['action'] = "/admin/services-categories/" . $result['entry']->id;
            $result['model'] = "admin.services-categories";

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return view('helpers.form-builder')
            ->with(['form' => $result]);
    }

    public function importEntries(Request $request)
    {
        dd('uepa');
        return;
    }
    public function updateEntry(Request $request)
    {
        $id = $request->id;
        $data = $request->except([
            '_token'
        ]);
        try {
            $data['id'] = $id;
            $service = $this->serviceCategoryService->saveServiceCategoryData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.services-categories.index');
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->serviceCategoryService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.services-categories.index');
    }
}