<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\ServiceService;
use App\Services\CompanyService;
use App\Services\CompanyCategoryService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var ProductService
     * @var ServiceService
     * @var CompanyService
     * @var CompanyCategoryService
     */
    protected ProductService $productService;
    protected ServiceService $serviceService;
    protected CompanyService $companyService;
    protected CompanyCategoryService $companyCategoryService;

    /**
     * @param ProductService $productService
     * @param ServiceService $serviceService
     * @param CompanyService $companyService
     * @param CompanyCategoryService $companyCategoryService;
     */
    public function __construct(
        ProductService $productService,
        ServiceService $serviceService,
        CompanyService $companyService,
        CompanyCategoryService $companyCategoryService
    ) {
        $this->productService = $productService;
        $this->serviceService = $serviceService;
        $this->companyService = $companyService;
        $this->companyCategoryService = $companyCategoryService;
    }

    /**
     * Search Functionality.
     */
    public function search(Request $request)
    {

        $products = $this->productService->getFiltered($request->query(), 25);
        $products->categories = $this->productService->getAllCategories(25);
        foreach ($products as $key => $product) {
            $gallery = $this->productService->getGallery($product->id, 1);
            $company = $this->companyService->getById($product->company_id);
            $product->company_name = $company->name;
            $product->company_slug = $company->slug;
            if (!empty($gallery->items()))
                $product->image = $gallery[0]->file_location;
        }
        $services = $this->serviceService->getFiltered($request->query(), 25);
        $services->categories = $this->serviceService->getAllCategories(25);
        foreach ($services as $key => $service) {
            $gallery = $this->serviceService->getGallery($service->id, 1);
            $company = $this->companyService->getById($service->company_id);
            $service->company_name = $company->name;
            $service->company_slug = $company->slug;
            if (!empty($gallery->items()))
                $service->image = $gallery[0]->file_location;
        }
        $companies = $this->companyService->getFiltered($request->query(), 25);
        foreach ($companies as $key => $company) {
            $company->segment = $this->companyCategoryService->getById($company->company_category_id)->name;
            $gallery = $this->companyService->getGallery($company->id, 25);
            if (!empty($gallery->items()))
                $company->image = $gallery[0]->file_location;
        }
        $entries = [
            'products' => $products,
            'services' => $services,
            'companies' => $companies,
        ];

        return view('search-page')->with(['entries' => $entries]);
    }

}