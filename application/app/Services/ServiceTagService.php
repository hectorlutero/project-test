<?php

namespace App\Services;

use App\Repositories\ServiceTagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceTagService
{
    /**
     * @var ServiceTagRepository
     */
    protected ServiceTagRepository $serviceTagRepository;

    /**
     * @param ServiceTagRepository $serviceTagRepository
     */
    public function __construct(ServiceTagRepository $serviceTagRepository)
    {
        $this->serviceTagRepository = $serviceTagRepository;
    }

    /**
     * Select all serviceTags
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->serviceTagRepository->getAllServicesTags($paginate);

    }

    /**
     * Filter serviceTags
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate)
    {
        return $this->serviceTagRepository->getFilteredServiceTags($filters, $paginate);
    }

    public function filterServiceTagFieldInArray($field, $array, $paginate, $orderField, $order)
    {
        return $this->serviceTagRepository->filterServiceTagFieldInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields()
    {
        return $this->serviceTagRepository->getServiceTagFields();
    }

    /**
     * Select a serviceTag by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->serviceTagRepository->getServiceTagById($id);
    }

    /**
     * Create a new ServiceTag
     * @param array $data
     * @return object
     */
    public function saveServiceTagData(array $data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:service_tags|required',
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $serviceTag = $this->serviceTagRepository->save($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update serviceTag data');
        }

        DB::commit();

        return $serviceTag;
    }

    /**
     * Delete a ServiceTag
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $serviceTag = $this->serviceTagRepository->destroyServiceTag($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete serviceTag');
        }
        DB::commit();

        return $serviceTag;
    }
}
