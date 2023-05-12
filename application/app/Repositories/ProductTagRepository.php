<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ProductTagRepository
{
    /**
     * @var ProductTag
     */
    protected $productTag;

    /**
     * ProductTagRepository constructor
     * @param ProductTag $productTag
     */
    public function __construct(ProductTag $productTag)
    {
        $this->productTag = $productTag;
    }

    /**
     * Get all TagOfProduct
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProductsTags($paginate)
    {
        return $this->productTag->paginate($paginate);
    }

    public function filterProductTagFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->productTag->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredProductsTags($filterParams, $paginate)
    {
        $filtered = $this->productTag->query();
        if (empty($filterParams['term']))
            return $filtered->paginate($paginate);
        $fields = $this->getSearchableFields();
        foreach ($fields as $key => $field) {
            $filtered->orWhere($field, 'LIKE', "%" . $filterParams['term'] . "%");
        }

        return $filtered->orderBy('id')->paginate($paginate);

    }

    public function getSearchableFields()
    {
        return [
            "name",
        ];
    }

    public function getProductTagFields()
    {

        $fields = [
            "name" => "input:text|size:2",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Product by ID
     * @param int $id
     * @return object
     */
    public function getProductTagById(int $id)
    {
        return $this->productTag->where('id', $id)->first();
    }

    /**
     * Create a new Product
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            try {
                $entry = $this->productTag->create($data);
            } catch (\Throwable $th) {
                dd($th);
            }
        } else {
            $entry = $this->productTag->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a product
     * @param int $id
     */
    public function destroyProductTag(int $id)
    {
        $productTag = $this->productTag->find($id);
        $productTag->delete();

        return $productTag;
    }
}
