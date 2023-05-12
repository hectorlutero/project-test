<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\ProductCategoryRepository;
use App\Services\ImportSpreadsheetService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * @var ProductRepository
     * @var ProductCategoryRepository
     * @var ImportSpreadsheetService
     */
    protected ProductRepository $productRepository;
    protected ProductCategoryRepository $productCategoryRepository;
    protected ImportSpreadsheetService $importSpreadsheetService;

    /**
     * @param ProductRepository $productRepository
     * @param ProductCategoryRepository $productCategoryRepository
     * @param ImportSpreadsheetService $importSpreadsheetService
     */
    public function __construct(ProductRepository $productRepository, ImportSpreadsheetService $importSpreadsheetService, ProductCategoryRepository $productCategoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->importSpreadsheetService = $importSpreadsheetService;
    }

    /**
     * Select all products
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->productRepository->getAllProducts($paginate);
    }

    /**
     * Filter products
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate, $userId = null)
    {
        return $this->productRepository->getFilteredProducts($filters, $paginate, $userId);
    }

    public function filterProductFieldInArray($field, $array, $paginate, $orderField, $order, $companyId = null, $userId = null)
    {
        return $this->productRepository->filterProductFieldInArray($field, $array, $paginate, $orderField, $order, $companyId, $userId);
    }

    public function getFields()
    {
        return $this->productRepository->getProductFields();
    }

    /**
     * Select a product by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        intval($id);
        return $this->productRepository->getProductById($id);
    }

    /**
     * Select all categories of products
     * @param int $paginate
     * @return object
     */
    public function getAllCategories($paginate)
    {
        return $this->productCategoryRepository->getAllProductsCategories($paginate);
    }

    /**
     * Create a new Product
     * @param array $data
     * @return object
     */
    public function saveProductData(array $data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:products|required',
                'description' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $product = $this->productRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update product data');
        }

        DB::commit();

        return $product;
    }

    /**
     * Import a Product Spreadsheet
     * @param array $data
     * @return object
     */
    public function importProductData(array $data)
    {
        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $product = $this->importSpreadsheetService->importData($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update product data');
        }

        DB::commit();

        return $product;
    }

    /**
     * Delete a Product
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->destroyProduct($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete product');
        }
        DB::commit();

        return $product;
    }

    /**
     * Select all media gallery
     * @return array
     */
    public function getGallery($id, $paginate)
    {
        return $this->productRepository->getGallery($id, $paginate);
    }

    /**
     * Save media gallery
     * @param array $data
     * @return array
     */
    public function saveMediaData($data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'media' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            if ($validator->fails()) {
                flash()->addError('Os formatos de imagem permitidos são jpg, jpeg, png e webp.');
                throw new \InvalidArgumentException('Incapaz de cadastrar produto.');
                return;
            }
        }
        DB::beginTransaction();

        try {
            $uuid = Str::uuid();
            // Move the uploaded file to the storage path
            $file_path = Storage::putFileAs('public/images', $data['media'], $uuid . '.' . $data['media']->getClientOriginalExtension());
            $data['uuid'] = $uuid;
            $data['file_location'] = str_replace('public/', '', $file_path);
            $data['file_name'] = $data['media']->getClientOriginalName();
            $data['file_format'] = $data['media']->getClientOriginalExtension();
            $data['entities_type'] = 'products';
            $data = array_filter($data);
            $media = $this->productRepository->saveMedia($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \InvalidArgumentException('Unable to update media data');
        }

        DB::commit();

        return $media;
    }


    /**
     * Delete a Product Media
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function deleteMedia(int $id)
    {
        DB::beginTransaction();

        try {
            $product = $this->productRepository->destroyProductMedia($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete product');
        }
        DB::commit();

        return $product;
    }
}