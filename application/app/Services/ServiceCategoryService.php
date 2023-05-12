<?php

namespace App\Services;

use App\Repositories\ServiceCategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryService
{
    /**
     * @var ServiceCategoryRepository
     */
    protected ServiceCategoryRepository $serviceCategoryRepository;

    /**
     * @param ServiceCategoryRepository $serviceCategoryRepository
     */
    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    /**
     * Select all serviceCategorys
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->serviceCategoryRepository->getAllServicesCategories($paginate);
    }

    /**
     * Filter serviceCategorys
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->serviceCategoryRepository->getFilteredServiceCategories($filters, $paginate);
    }

    public function filterServiceCategoryFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->serviceCategoryRepository->filterServiceCategoryFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->serviceCategoryRepository->getServiceCategoryFields();
    }

    /**
     * Select a serviceCategory by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->serviceCategoryRepository->getServiceCategoryById($id);
    }

    /**
     * Create a new ServiceCategory
     * @param array $data
     * @return object
     */
    public function saveServiceCategoryData(array $data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:service_categories|required',
            ]);
            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $serviceCategory = $this->serviceCategoryRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update serviceCategory data');
        }

        DB::commit();

        return $serviceCategory;
    }

    /**
     * Delete a ServiceCategory
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $serviceCategory = $this->serviceCategoryRepository->destroyServiceCategory($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete serviceCategory');
        }
        DB::commit();

        return $serviceCategory;
    }
}
