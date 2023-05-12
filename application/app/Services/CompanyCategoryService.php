<?php

namespace App\Services;

use App\Repositories\CompanyCategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CompanyCategoryService
{
    /**
     * @var CompanyCategoryRepository
     */
    protected CompanyCategoryRepository $companyCategoryRepository;

    /**
     * @param CompanyCategoryRepository $companyCategoryRepository
     */
    public function __construct(CompanyCategoryRepository $companyCategoryRepository)
    {
        $this->companyCategoryRepository = $companyCategoryRepository;
    }

    /**
     * Select all companyCategorys
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->companyCategoryRepository->getAllCompanyCategories($paginate);

    }

    /**
     * Filter companyCategorys
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->companyCategoryRepository->getFilteredCompanyCategories($filters, $paginate);
    }

    public function filterCompanyCategoryFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->companyCategoryRepository->filterCompanyCategoryFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->companyCategoryRepository->getCompanyCategoryFields();
    }

    /**
     * Select a companyCategory by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->companyCategoryRepository->getCompanyCategoryById($id);
    }

    /**
     * Create a new CompanyCategory
     * @param array $data
     * @return object
     */
    public function saveCompanyCategoryData(array $data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:company_categories|required',
                'slug' => 'unique:company_categories|required',
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $companyCategory = $this->companyCategoryRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update companyCategory data');
        }

        DB::commit();

        return $companyCategory;
    }

    /**
     * Delete a CompanyCategory
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $companyCategory = $this->companyCategoryRepository->destroyCompanyCategory($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete companyCategory');
        }
        DB::commit();

        return $companyCategory;
    }
}
