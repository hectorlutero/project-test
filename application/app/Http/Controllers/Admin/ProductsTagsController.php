<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductTagService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ProductsTagsController extends Controller
{
    protected ProductTagService $productTagService;

    public function __construct(ProductTagService $productTagService)
    {
        $this->productTagService = $productTagService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {
            $list = $this->productTagService->getAll(25);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.products-tags')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando tag de produto";
        } else {
            $result['entry'] = $this->productTagService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->productTagService->getFields()['fields'];
            $result['action'] = "/admin/products-tags/" . $result['entry']->id;
            $result['model'] = "admin.products-tags";

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
            $product = $this->productTagService->saveProductTagData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.products-tags.index');
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->productTagService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.products-tags.index');
    }
}