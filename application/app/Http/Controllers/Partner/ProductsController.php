<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CompanyService;
use App\Services\ImportSpreadsheetService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected ProductService $productService;
    protected CompanyService $companyService;
    protected ImportSpreadsheetService $importSpreadsheetService;

    public function __construct(
        ProductService $productService,
        CompanyService $companyService,
        ImportSpreadsheetService $importSpreadsheetService
    ) {
        $this->productService = $productService;
        $this->companyService = $companyService;
        $this->importSpreadsheetService = $importSpreadsheetService;
    }

    public function showList(Request $request)
    {
        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $statusFilter = $request->filter ?? 'pending_approval';
        $company_id = $request->company_id ?? 'all';


        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($statusFilter, 'pending_approval'),
                    'value' => 'DRAFT',
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
            $list = $this->productService->filterProductFieldInArray('status', $checkedOptions, 25, 'id', $order, $company_id, auth()->id())->appends(['order' => $order]);
            foreach ($list as $product) {
                $gallery = $this->productService->getGallery($product->id, 25);
                $product->image_count = count($gallery);
                $company = $this->companyService->getById($product->company_id);
                $product->company_name = $company->name;
                $product->company_slug = $company->slug;
                $product->company_id = $company->id;
            }

            $entries['checkedOptions'] = join("|", $checkedOptions);
            $entries['list'] = $list;
            $entries['companies'] = $this->companyService->filterCompanyFieldInArray('status', $checkedOptions, 25, 'id', $order, auth()->id());
            $entries['type'] = 'product';
            $entries['company_id'] = $request->company_id ?? '';

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.partners.products')
            ->with(['entries' => $entries]);
    }

    public function search(Request $request)
    {

        $entries = ['status' => 200];

        $order = $request->order ?? "desc";
        $statusFilter = $request->filter ?? 'pending_approval';
        $company_id = $request->company_id ?? 'all';


        try {

            $entries['filtersMenu'] = [
                [
                    'checked' => str_contains($statusFilter, 'pending_approval'),
                    'value' => 'DRAFT',
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

            if (empty($checkedOptions)) {
                $checkedOptions = [0 => 'DRAFT', 1 => 'PUBLISHED'];
            }

            $list = $this->productService->getFiltered($request->except(['_token']), 25, auth()->id());
            foreach ($list as $product) {
                $gallery = $this->productService->getGallery($product->id, 25);
                $product->image_count = count($gallery);
                $company = $this->companyService->getById($product->company_id);
                $product->company_name = $company->name;
                $product->company_slug = $company->slug;
                $product->company_id = $company->id;
            }

            $entries['checkedOptions'] = join("|", $checkedOptions);
            $entries['list'] = $list;
            $entries['companies'] = $this->companyService->filterCompanyFieldInArray('status', $checkedOptions, 25, 'id', $order, auth()->id());
            $entries['type'] = 'product';
            $entries['company_id'] = $request->company_id ?? '';


        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
            return response()->json($result, $result['status']);
        }

        return view('pages.partners.products')
            ->with(['entries' => $entries]);
    }

    public function exportModel(Request $request)
    {

        try {
            $product = $this->importSpreadsheetService->downloadModel('product');
            // Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return $product;
    }

    public function importEntries(Request $request)
    {
        $data = $request->except([
            '_token'
        ]);
        $data['type'] = 'product';
        try {
            $product = $this->productService->importProductData($data);
            if ($product['status'] === "success")
                flash()->addSuccess($product['msg']);
            else if ($product['status'] === "warning")
                flash()->addWarning($product['msg']);
            else
                flash()->addError($product['msg']);

            // Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('partner.products.index');
    }

    public function showEntry($id, $companyId = null)
    {
        $result = ['status' => 200];
        if ($id == 'new') {
            $result['entry'] = (object) ['id' => 'new'];
            $result['title'] = "Criando produto";
            $result['company_id'] = $companyId;
        } else {
            $result['entry'] = $this->productService->getById($id);
            $result['title'] = "Editando: " . $result['entry']->name;
            $result['company_id'] = $companyId;
        }

        try {
            $form = $this->productService->getFields();
            $result['fields'] = $form['fields'];
            $result['js'] = $form['js'];
            $result['action'] = "/partner/product/" . $result['entry']->id;
            $result['model'] = "partner.products";
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

            $product = $this->productService->saveProductData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {

            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }

        return redirect()->route('partner.products.index', ['company_id' => $product->company_id]);
    }

    public function deleteEntry(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->productService->delete($request->id);
            Flasher::addPreset("entity_deleted");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_removal_error");
        }

        return redirect()->route('partner.products.index');
    }

    public function deleteEntries(Request $request)
    {
        $products = json_decode($request->values);
        $result = ['status' => 200];
        try {
            $result['data'] = [];
            foreach ($products as $productId) {
                $result['data'][] = $this->productService->delete($productId);
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
            'type_plural' => 'products',
            'type_singular' => 'product',
            'id' => $request->id
        ];

        $order = $request->order ?? "desc";

        try {
            $list = $this->productService->getGallery($request->id, 25);
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
            $product = $this->productService->saveMediaData($data);
            Flasher::addPreset("entity_saved");
        } catch (\Exception $e) {
            Flasher::addPreset("entity_error");
            return redirect()->back()->withInput();
        }
        // $url = route('partner.products.gallery', ['id' => $id]);

        return back();
    }

    public function deleteMedia(Request $request)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->productService->deleteMedia($request->id);
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