<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    protected CompanyRepository $companyRepository;

    /**
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Select all companies
     * @return LengthAwarePaginator
     */
    public function getAll($paginate)
    {
        return $this->companyRepository->getAllCompanies($paginate);
    }

    /**
     * Filter companies
     * @return LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate, $userId = null)
    {
        return $this->companyRepository->getFilteredCompanies($filters, $paginate, $userId);
    }

    public function filterCompanyFieldInArray($fields, $array, $paginate, $orderField, $order, $userId)
    {
        return $this->companyRepository->filterCompanyFieldInArray($fields, $array, $paginate, $orderField, $order, $userId);
    }

    public function getFields()
    {
        return $this->companyRepository->getCompanyFields();
    }

    /**
     * Select a company by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->companyRepository->getCompanyById($id);
    }

    /**
     * Create a new Company
     * @param array $data
     * @param int $userId
     * @return object
     */
    public function saveCompanyData(array $data, int $userId = null)
    {

        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'document' => 'unique:companies|required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);

            $company = $this->companyRepository->save($data, $userId);
            $data['entities_id'] = $company->id;
            $data['id'] = 'new';
            if (isset($data['logo_id'])) {
                $data['logo_id'] = $this->saveMediaData($data)->id;
                unset($data['entities_id']);
                $data['id'] = $company->id;
                $company = $this->companyRepository->save($data, $userId);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            throw new \InvalidArgumentException('Unable to update company data');
        }

        DB::commit();

        return $company;
    }

    /**
     * Delete a Company
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $company = $this->companyRepository->destroyCompany($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete company');
        }
        try {
            DB::commit();
        } catch (\Throwable $th) {
            dd('services =>', $th);
        }

        return $company;
    }

    public function manageBan(int $id)
    {
        DB::beginTransaction();
        try {
            $this->companyRepository->manageCompanyBan($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Erro ao alterar status da empresa');
        }
        try {
            DB::commit();
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException('Erro ao alterar status da empresa');
        }

        return true;
    }

    /**
     * Select one media gallery
     * @return array
     */
    public function getMediaGallery($id)
    {
        return $this->companyRepository->getMediaGallery($id);
    }
    /**
     * Select all media gallery
     * @return array
     */
    public function getGallery($id, $paginate)
    {
        return $this->companyRepository->getGallery($id, $paginate);
    }

    /**
     * Save media gallery
     * @param array $data
     * @return array
     */
    public function saveMediaData($data)
    {
        if ($data['id'] == 'new') {
            if (isset($data['logo_id'])) {
                $validator = Validator::make($data, [
                    'logo_id' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                if ($validator->fails()) {
                    flash()->addError('Os formatos de imagem permitidos são jpg, jpeg, png e webp.');
                    throw new \InvalidArgumentException('Incapaz de cadastrar produto.');
                }
            } else {

                $validator = Validator::make($data, [
                    'media' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);
                if ($validator->fails()) {
                    flash()->addError('Os formatos de imagem permitidos são jpg, jpeg, png e webp.');
                    throw new \InvalidArgumentException('Incapaz de cadastrar produto.');
                }
            }
        }
        DB::beginTransaction();

        try {

            $uuid = Str::uuid();
            $data['uuid'] = $uuid;
            if (isset($data['logo_id'])) {
                $file_path = Storage::putFileAs('public/images', $data['logo_id'], $uuid . '.' . $data['logo_id']->getClientOriginalExtension());
                $data['file_name'] = $data['logo_id']->getClientOriginalName();
                $data['file_format'] = $data['logo_id']->getClientOriginalExtension();
            } else {
                $file_path = Storage::putFileAs('public/images', $data['media'], $uuid . '.' . $data['media']->getClientOriginalExtension());
                $data['file_name'] = $data['media']->getClientOriginalName();
                $data['file_format'] = $data['media']->getClientOriginalExtension();
            }
            // Move the uploaded file to the storage path
            $data['file_location'] = str_replace('public/', '', $file_path);
            $data['entities_type'] = 'companies';
            $data = array_filter($data);
            $media = $this->companyRepository->saveMedia($data);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            throw new \InvalidArgumentException('Unable to update media data');
        }

        DB::commit();

        return $media;
    }


    /**
     * Delete a Product Media
     * @param int $id
     * @return \Illuminate\Http\JsonResponse response
     */
    public function deleteMedia(int $id)
    {
        DB::beginTransaction();

        try {
            $company = $this->companyRepository->destroyCompanyMedia($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete company media');
        }
        DB::commit();

        return $company;
    }
}