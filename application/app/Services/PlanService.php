<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlanService
{
    /**
     * @var PlanRepository
     */
    protected PlanRepository $planRepository;

    /**
     * @param PlanRepository $planRepository
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    /**
     * Select all plans
     * @return LengthAwarePaginator
     */
    public function getAll($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->planRepository->getAllPlans($paginate, $orderField, $order);

    }

    /**
     * Filter plans
     * @return LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate): LengthAwarePaginator
    {
        return $this->planRepository->getFilteredPlan($filters, $paginate);
    }

    public function filterPlanFieldInArray($field, $array, $paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->planRepository->filterPlanInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields(): array
    {
        return $this->planRepository->getPlanFields();
    }

    /**
     * Select a plan by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->planRepository->getPlanById($id);
    }

    /**
     * Create a new Plan
     * @param array $data
     * @return object
     */
    public function savePlanData(array $data): object
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:plans|required',
                'price' => 'required|numeric',
                'description' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $plan = $this->planRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update plan data');
        }

        DB::commit();

        return $plan;
    }

    /**
     * Delete a Plan
     * @param int $id
     * @return object  response
     */
    public function delete(int $id): object
    {
        DB::beginTransaction();

        try {
            $plan = $this->planRepository->destroyPlan($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete plan');
        }
        DB::commit();

        return $plan;
    }
}