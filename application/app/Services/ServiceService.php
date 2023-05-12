<?php

namespace App\Services;

use App\Repositories\ServiceRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Services\ImportSpreadsheetService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceService
{
    /**
     * @var ServiceRepository
     * @var ServiceCategoryRepository;
     * @var ImportSpreadsheetService
     */
    protected ServiceRepository $serviceRepository;
    protected ServiceCategoryRepository $serviceCategoryRepository;
    protected ImportSpreadsheetService $importSpreadsheetService;

    /**
     * @param ServiceRepository $serviceRepository
     * @param ServiceCategoryRepository $serviceCategoryRepository;
     * @param ImportSpreadsheetService $importSpreadsheetService
     */
    public function __construct(ServiceRepository $serviceRepository, ImportSpreadsheetService $importSpreadsheetService, ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceCategoryRepository = $serviceCategoryRepository;
        $this->importSpreadsheetService = $importSpreadsheetService;
    }

    /**
     * Select all services
     * @return array
     */
    public function getAll($paginate)
    {
        return $this->serviceRepository->getAllServices($paginate);
    }

    /**
     * Select all media gallery
     * @return array
     */
    public function getGallery($id, $paginate)
    {
        return $this->serviceRepository->getGallery($id, $paginate);
    }


    /**
     * Filter services
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate, $userId = null)
    {
        return $this->serviceRepository->getFilteredServices($filters, $paginate, $userId);
    }

    public function filterServiceFieldInArray($field, $array, $paginate, $orderField, $order, $companyId = null, $userId = null)
    {
        return $this->serviceRepository->filterServiceFieldInArray($field, $array, $paginate, $orderField, $order, $companyId, $userId);
    }

    public function getFields()
    {
        return $this->serviceRepository->getServiceFields();
    }

    /**
     * Select a service by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->serviceRepository->getServiceById($id);
    }

    /**
     * Select all categories of services
     * @param int $paginate
     * @return object
     */
    public function getAllCategories($paginate)
    {
        return $this->serviceCategoryRepository->getAllServicesCategories($paginate);
    }

    /**
     * Create a new Service
     * @param array $data
     * @return object
     */
    public function saveServiceData(array $data)
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:services|required',
                'description' => 'required',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();
        try {
            if (empty($data['status'])) {

                try {
                    $data['is24_7'];
                } catch (\Exception $e) {
                    throw new \InvalidArgumentException($e->getMessage());
                }
                $is24_7 = $data['is24_7'];
                $data = array_filter($data);
                $data['is24_7'] = $is24_7;
                $service = $this->serviceRepository->save($data);
            } else {
                $data = array_filter($data);
                $service = $this->serviceRepository->save($data);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException($e->getMessage());
        }

        DB::commit();

        return $service;
    }

    /**
     * Import a Service Spreadsheet
     * @param array $data
     * @return object
     */
    public function importServiceData(array $data)
    {
        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $product = $this->importSpreadsheetService->importData($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update service data');
        }

        DB::commit();

        return $product;
    }


    public function saveMediaData(array $data)
    {
        if ($data['id'] == 'new') {
            try {
                $validator = Validator::make($data, [
                    'media' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                if ($validator->fails()) {
                    throw new \InvalidArgumentException($validator->errors()->first());
                }
            } catch (\Throwable $th) {
                dd($th);
            }
        }
        DB::beginTransaction();

        try {
            $uuid = Str::uuid();
            // Move the uploaded file to the storage path
            $file_path = Storage::putFileAs('public/images', $data['media'], $uuid . '.' . $data['media']->getClientOriginalExtension());
            $data['uuid'] = $uuid;
            $data['file_location'] = str_replace('public/', '', $file_path);
            $data['file_name'] = $data['media']->getClientOriginalName();
            $data['file_format'] = $data['media']->getClientOriginalExtension();
            $data['entities_type'] = 'services';
            $data = array_filter($data);

            $media = $this->serviceRepository->saveMedia($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \InvalidArgumentException('Unable to update media data');
        }

        DB::commit();

        return $media;
    }


    /**
     * Delete a Service
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $service = $this->serviceRepository->destroyService($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete service');
        }
        DB::commit();

        return $service;
    }

    /**
     * Delete a Service Media
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function deleteMedia(int $id)
    {
        DB::beginTransaction();

        try {
            $product = $this->serviceRepository->destroyServiceMedia($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete product');
        }
        DB::commit();

        return $product;
    }
}