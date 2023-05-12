<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductCategoryRepository
{
    /**
     * @var ProductCategory
     */
    protected ProductCategory $productCategory;

    /**
     * ProductCategoryRepository constructor
     * @param ProductCategory $productCategory
     */
    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    /**
     * Get all ProductCategorys
     * @return LengthAwarePaginator
     */
    public function getAllProductsCategories($paginate): LengthAwarePaginator
    {
        return $this->productCategory->paginate($paginate);
    }

    public function filterProductCategoryFieldInArray($field, $array, $paginate, $orderField, $order): LengthAwarePaginator
    {
        $filtered = $this->productCategory->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredProductsCategories($filterParams, $paginate): LengthAwarePaginator
    {
        $filtered = $this->productCategory->query();
        if (empty($filterParams['term']))
            return $filtered->paginate($paginate);
        $fields = $this->getSearchableFields();
        foreach ($fields as $key => $field) {
            $filtered->orWhere($field, 'LIKE', "%" . $filterParams['term'] . "%");
        }

        return $filtered->orderBy('id')->paginate($paginate);

    }

    public function getSearchableFields(): array
    {
        return [
            "name",
            "slug",
            "icon"
        ];
    }

    public function getProductCategoryFields(): array
    {

        $fields = [
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "icon" => "input:text|size:2",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Product by ID
     * @param int $id
     * @return object
     */
    public function getProductCategoryById(int $id): object
    {
        return $this->productCategory->where('id', $id)->first();
    }

    /**
     * Create a new Product
     * @param array $data
     * @return object
     */
    public function save(array $data): object
    {

        if ($data['id'] == 'new') {
            unset($data['id']);
            try {
                $entry = $this->productCategory->create($data);
            } catch (\Throwable $th) {
                dd($th);
            }
        } else {
            $entry = $this->productCategory->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a product
     * @param int $id
     */
    public function destroyProductCategory(int $id)
    {
        $productCategory = $this->productCategory->find($id);
        $productCategory->delete();

        return $productCategory;
    }
}
