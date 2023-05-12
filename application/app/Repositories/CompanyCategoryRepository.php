<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\CompanyCategory;

class CompanyCategoryRepository
{

    protected $companyCategory;

    public function __construct(CompanyCategory $companyCategory)
    {
        $this->companyCategory = $companyCategory;
    }

    public function getAllCompanyCategories($paginate)
    {
        return $this->companyCategory->paginate($paginate);
    }

    public function filterCompanyCategoryFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->companyCategory->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredCompanyCategories($filterParams, $paginate)
    {
        $filtered = $this->companyCategory->query();
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
            "slug"
        ];
    }

    public function getCompanyCategoryFields()
    {

        $fields = [
            "is_active" => "input:radio|size:2|opts:[Y=Sim,N=Não]",
            "name" => "input:text|size:2,attrs:id=name",
            "slug" => "input:text|size:2,attrs:id=slug",
            "allow_products" => "input:radio|size:2|opts:[Y=Sim,N=Não]",
            "allow_services" => "input:radio|size:2|opts:[Y=Sim,N=Não]",
            "icon" => "input:text|size:2",
        ];

        return ["fields" => $fields];
    }

    /**
     * Get CompanyCategory by ID
     * @param int $id
     * @return object
     */
    public function getCompanyCategoryById(int $id)
    {
        return $this->companyCategory->where('id', $id)->first();
    }

    /**
     * Create a new CompanyCategory
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            $entry = $this->companyCategory->create($data);
        } else {
            $entry = $this->companyCategory->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a service
     * @param int $id
     */
    public function destroyCompanyCategory(int $id)
    {
        $companyCategory = $this->companyCategory->find($id);
        $companyCategory->delete();

        return $companyCategory;
    }
}
