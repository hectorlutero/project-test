<?php

namespace App\Services;

use App\Repositories\ProductCategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductCategoryService
{
    /**
     * @var ProductCategoryRepository
     */
    protected ProductCategoryRepository $productCategoryRepository;

    /**
     * @param ProductCategoryRepository $productCategoryRepository
     */
    public function __construct(ProductCategoryRepository $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * Select all productCategorys
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->productCategoryRepository->getAllProductsCategories($paginate);
    }

    /**
     * Filter productCategorys
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->productCategoryRepository->getFilteredProductsCategories($filters, $paginate);
    }

    public function filterProductCategoryFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->productCategoryRepository->filterProductCategoryFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->productCategoryRepository->getProductCategoryFields();
    }

    /**
     * Select a productCategory by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->productCategoryRepository->getProductCategoryById($id);
    }

    /**
     * Create a new ProductCategory
     * @param array $data
     * @return object
     */
    public function saveProductCategoryData(array $data)
    {

        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:product_categories|required',
            ]);
            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $productCategory = $this->productCategoryRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update productCategory data');
        }

        DB::commit();

        return $productCategory;
    }

    /**
     * Delete a ProductCategory
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $productCategory = $this->productCategoryRepository->destroyProductCategory($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete productCategory');
        }
        DB::commit();

        return $productCategory;
    }
}
