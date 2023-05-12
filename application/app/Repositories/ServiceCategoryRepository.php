<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ServiceCategoryRepository
{
    /**
     * @var ServiceCategory
     */
    protected ServiceCategory $serviceCategory;

    /**
     * ServiceCategoryRepository constructor
     * @param ServiceCategory $serviceCategory
     */
    public function __construct(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
    }

    /**
     * Get all ServiceCategorys
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllServicesCategories($paginate)
    {
        return $this->serviceCategory->paginate($paginate);
    }

    public function filterServiceCategoryFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->serviceCategory->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredServicesCategories($filterParams, $paginate)
    {
        $filtered = $this->serviceCategory->query();
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
            "slug",
            "icon"
        ];
    }

    public function getServiceCategoryFields()
    {

        $fields = [
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "icon" => "input:text|size:2",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Service by ID
     * @param int $id
     * @return object
     */
    public function getServiceCategoryById(int $id)
    {
        return $this->serviceCategory->where('id', $id)->first();
    }

    /**
     * Create a new Service
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            $entry = $this->serviceCategory->create($data);
        } else {
            $entry = $this->serviceCategory->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a service
     * @param int $id
     */
    public function destroyServiceCategory(int $id)
    {
        $serviceCategory = $this->serviceCategory->find($id);
        $serviceCategory->delete();

        return $serviceCategory;
    }
}
