<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductCategoryService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ProductsCategoriesController extends Controller
{
    protected ProductCategoryService $productCategoryService;

    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";

        try {

            $list = $this->productCategoryService->getAll(25);
            $entries['list'] = $list;

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.admin.partners.products-categories')
            ->with(['entries' => $entries]);
    }

    public function showEntry($id)
    {
        $result = ['status' => 200];

        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando categoria de produto";
        } else {
            $result['entry'] = $this->productCategoryService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
        }

        try {

            $result['fields'] = $this->productCategoryService->getFields()['fields'];
            $result['action'] = "/admin/products-categories/" . $result['entry']->id;
            $result['model'] = "admin.products-categories";

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
            $product = $this->productCategoryService->saveProductCategoryData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('admin.products-categories.index');
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->productCategoryService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('admin.products-categories.index');
    }
}