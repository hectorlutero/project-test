<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompanyCategoryService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class CompanyCategoryController extends Controller
{
    protected CompanyCategoryService $companyCategoryService;

    public function __construct(CompanyCategoryService $companyCategoryService)
    {
        $this->companyCategoryService = $companyCategoryService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {
            $list = $this->companyCategoryService->getAll(25);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.company-category')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando tags de serviço";
        } else {
            $result['entry'] = $this->companyCategoryService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->companyCategoryService->getFields()['fields'];
            $result['action'] = "/admin/company-categories/" . $result['entry']->id;
            $result['model'] = "admin.company-categories";

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
            $this->companyCategoryService->saveServiceTagData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.company-categories.index');
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->companyCategoryService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.company-categories.index');
    }
}
