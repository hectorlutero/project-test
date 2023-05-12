<?php

namespace App\Services;

use App\Repositories\ProductTagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductTagService
{
    /**
     * @var ProductTagRepository
     */
    protected ProductTagRepository $productTagRepository;

    /**
     * @param ProductTagRepository $productTagRepository
     */
    public function __construct(ProductTagRepository $productTagRepository)
    {
        $this->productTagRepository = $productTagRepository;
    }

    /**
     * Select all productTags
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->productTagRepository->getAllProductsTags($paginate);
    }

    /**
     * Filter productTags
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->productTagRepository->getFilteredProductsTags($filters, $paginate);
    }

    public function filterProductTagFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->productTagRepository->filterProductTagFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->productTagRepository->getProductTagFields();
    }

    /**
     * Select a productTag by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->productTagRepository->getProductTagById($id);
    }

    /**
     * Create a new ProductTag
     * @param array $data
     * @return object
     */
    public function saveProductTagData(array $data)
    {
        if ($data['id'] == 'new') {

            $validator = Validator::make($data, [
                'name' => 'unique:product_tags|required',
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $productTag = $this->productTagRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update productTag data');
        }

        DB::commit();

        return $productTag;
    }

    /**
     * Delete a ProductTag
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $productTag = $this->productTagRepository->destroyProductTag($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete productTag');
        }
        DB::commit();

        return $productTag;
    }
}
