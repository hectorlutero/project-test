<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\ServiceTag;

class ServiceTagRepository
{
    /**
     * @var ServiceTag
     */
    protected $serviceTag;

    /**
     * ServiceTagRepository constructor
     * @param ServiceTag $serviceTag
     */
    public function __construct(ServiceTag $serviceTag)
    {
        $this->serviceTag = $serviceTag;
    }

    /**
     * Get all ServiceTags
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllServicesTags($paginate)
    {
        return $this->serviceTag->paginate($paginate);
    }

    public function filterServiceTagFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->serviceTag->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredServicesTags($filterParams, $paginate)
    {
        $filtered = $this->serviceTag->query();
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

    public function getServiceTagFields()
    {

        $fields = [
            "name" => "input:text|size:2",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Service by ID
     * @param int $id
     * @return object
     */
    public function getServiceTagById(int $id)
    {
        return $this->serviceTag->where('id', $id)->first();
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
            $entry = $this->serviceTag->create($data);
        } else {
            $entry = $this->serviceTag->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a service
     * @param int $id
     */
    public function destroyServiceTag(int $id)
    {
        $serviceTag = $this->serviceTag->find($id);
        $serviceTag->delete();

        return $serviceTag;
    }
}
