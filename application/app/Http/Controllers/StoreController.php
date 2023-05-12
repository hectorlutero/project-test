<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\ServiceService;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;



class StoreController extends Controller
{
    /**
     * @var ProductService
     * @var ServiceService
     * @var CompanyService
     */
    protected ProductService $productService;
    protected ServiceService $serviceService;
    protected CompanyService $companyService;

    /**
     * @param ProductService $productService
     * @param ServiceService $serviceService
     * @param CompanyService $companyService
     */
    public function __construct(ProductService $productService, ServiceService $serviceService, CompanyService $companyService)
    {
        $this->productService = $productService;
        $this->serviceService = $serviceService;
        $this->companyService = $companyService;
    }

    public function showProduct(Request $request)
    {
        $product = $this->productService->getById($request->id);
        $company = $this->companyService->getById($product->company_id);
        $product->company = $company;
        $productGallery = $this->productService->getGallery($product->id, 5);
        $gallery = [];
        foreach ($productGallery as $image) {
            $gallery[] = $image->file_location;
        }
        $entries = [
            'item' => $product,
            'gallery' => $gallery
        ];
        return view('store.product')->with('product', $entries);
    }
    public function showService(Request $request)
    {
        $service = $this->serviceService->getById($request->id);
        $company = $this->companyService->getById($service->company_id);
        $service->company = $company;
        $serviceGallery = $this->serviceService->getGallery($service->id, 5);
        $gallery = [];
        foreach ($serviceGallery as $image) {
            $gallery[] = $image->file_location;
        }
        $entries = [
            'item' => $service,
            'gallery' => $gallery
        ];
        return view('store.service')->with('service', $entries);
    }
    public function showCompany(Request $request)
    {



        $company = $this->companyService->getById($request->id);
        $company->gallery = $this->companyService->getGallery($request->id, 25);
        $products = $this->productService->getFiltered(['search_by_field' => ['company_id', $company->id]], 25);
        foreach ($products as $product) {
            $gallery = $this->productService->getGallery($product->id, 1);
            if ($gallery[0] !== null) {
                $product->image = $gallery[0]->file_location;
            }
        }

        $services = $this->serviceService->getFiltered(['search_by_field' => ['company_id', $company->id]], 25);
        foreach ($services as $service) {
            $gallery = $this->serviceService->getGallery($service->id, 1);
            if ($gallery[0] !== null) {
                $service->image = $gallery[0]->file_location;
            }
        }
        $company->products = $products;
        $company->services = $services;
        // $filteredProducts = [];
        // $companyGallery = $this->companyService->getGallery($company->id, 5);
        $gallery = [];
        $entries = [
            'item' => $company,
            'gallery' => $gallery
        ];
        return view('store.company')->with('company', $entries);
    }
}