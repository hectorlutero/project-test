<?php

namespace App\Repositories;

use App\Helpers\ModelHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Plan;

class PlanRepository
{
    /**
     * @var Plan
     */
    protected Plan $plan;

    /**
     * PlanRepository constructor
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Get all Plans
     * @return LengthAwarePaginator
     */
    public function getAllPlans($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->plan->orderBy($orderField, $order)->paginate($paginate);
    }

    public function filterPlanInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->plan->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredPlan($filterParams, $paginate): LengthAwarePaginator
    {
        $filtered = $this->plan->query();
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
            "description"
        ];
    }

    public function getPlanFields(): array
    {

        $fields = [
            "name" => "input:text|size:2,attrs:required",
            "price" => "input:text|size:2,attrs:required",
            "duration" => "input:number|size:2",
            "recurrence" => "input:number|size:2",
            "description" => "textarea:plain|size:full,attrs:required"
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Plan by ID
     * @param int $id
     * @return object
     */
    public function getPlanById(int $id): object
    {
        return $this->plan->where('id', $id)->first();
    }

    /**
     * Create a new Plan
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            $entry = $this->plan->create($data);
        } else {
            $entry = $this->plan->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry))
                $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a Plan
     * @param int $id
     */
    public function destroyPlan(int $id)
    {
        $plan = $this->plan->find($id);
        $plan->delete();

        return $plan;
    }
}