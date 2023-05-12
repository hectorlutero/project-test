<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\Service;
use App\Models\File;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ServiceRepository
{
    /**
     * @var Service
     * @var CompanyRepository
     * @var File
     */

    protected $service;
    protected $company;
    protected $file;


    /**
     *  ServiceRepository constructor
     * 
     * @param Service $service
     * @param CompanyRepository $company
     * @param File $file
     */
    public function __construct(Service $service, CompanyRepository $company, File $file)
    {
        $this->service = $service;
        $this->company = $company;
        $this->file = $file;
    }

    /**
     * Get all Services
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllServices($paginate)
    {
        return $this->service->with('company')->with('files')->paginate($paginate);
    }

    /**
     * Get all media Gallery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGallery($id, $paginate)
    {
        return $this->service->find($id)->files()->paginate($paginate);
    }

    public function filterServiceFieldInArray($field, $array, $paginate, $orderField, $order, $companyId = null, $userId = null)
    {
        $filtered = $this->service->query();
        if ($companyId !== null || $userId !== null) {
            $companyIds = [];
            if ($companyId !== 'all') {
                $companyIds[] = $companyId;
            } else {
                $companyIds = User::find($userId)->companies()->pluck('id')->toArray();
            }

            $result = $filtered->whereIn("company_id", $companyIds);
            return $result->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
        }
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredServices($filterParams, $paginate, $userId = null)
    {
        $filtered = $this->service->query();
        $fields = $this->getSearchableFields();
        if ($userId !== null) {
            if (empty($filterParams['term'])) {
                if (empty($filterParams['search_by_field'])) {
                    $filtered->leftJoin('companies', 'services.company_id', '=', 'companies.id')
                        ->where('companies.user_id', '=', $userId);
                    return $filtered->select('services.*')->orderBy('services.id')->paginate($paginate);
                } else {
                    $requestedField = $filterParams['search_by_field'];
                    $fields = $this->getSearchableFields();
                    $filtered->leftJoin('companies', 'services.company_id', '=', 'companies.id')
                        ->where('companies.user_id', '=', $userId);
                    foreach ($fields as $field) {
                        if ($field === $requestedField[0])
                            $filtered->orWhere('services.' . $field, 'LIKE', "%" . $requestedField[1] . "%");
                    }
                    return $filtered->select('services.*')->orderBy('services.id')->paginate($paginate);
                }
            }


            $filtered
                ->leftJoin('companies', 'services.company_id', '=', 'companies.id')
                ->where('companies.user_id', '=', $userId)
                ->where(function (Builder $query) use ($fields, $filterParams) {
                    foreach ($fields as $field) {
                        $query->orWhere('services.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });

        } else {

            if (empty($filterParams['term'])) {
                if (empty($filterParams['search_by_field'])) {
                    return $filtered->orderBy('id')->paginate($paginate);
                } else {
                    $requestedField = $filterParams['search_by_field'];
                    $fields = $this->getSearchableFields();
                    foreach ($fields as $field) {
                        if ($field === $requestedField[0])
                            $filtered->orWhere('services.' . $field, 'LIKE', "%" . $requestedField[1] . "%");
                    }
                    return $filtered->orderBy('id')->paginate($paginate);
                }
            }
            $fields = $this->getSearchableFields();
            foreach ($fields as $key => $field) {
                $filtered->orWhere('services.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
            }
            $filtered->leftJoin('companies', 'services.company_id', '=', 'companies.id')
                ->orWhere(function ($query) use ($filterParams) {
                    $userFields = $this->company->getSearchableFields();
                    foreach ($userFields as $key => $field) {
                        $query->orWhere('companies.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });
        }

        return $filtered->select('services.*')->orderBy('id')->paginate($paginate);
    }

    public function getSearchableFields()
    {
        return [
            "name",
            "slug",
            "description",
            "execution_time",
            "price",
            "company_id",
            "is24_7",
            "working_days_start",
            "working_days_end",
            "saturdays_start",
            "saturdays_end",
            "sundays_n_holidays_start",
            "sundays_n_holidays_end",
        ];
    }

    public function getServiceFields()
    {

        $fields = [
            // "company_id" => "select:companies",
            "service_category_id" => "select:service_categories",
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "description" => "textarea:text",
            "execution_time" => "input:number",
            "price" => "input:text",
            "is24_7" => "input:checkbox",
            "working_days_start" => "input:time",
            "working_days_end" => "input:time",
            "saturdays_start" => "input:time",
            "saturdays_end" => "input:time",
            "sundays_n_holidays_start" => "input:time",
            "sundays_n_holidays_end" => "input:time",
        ];
        $js = "dashboard/service-form.js";

        return ["fields" => $fields, "js" => $js];
    }

    /**
     * Get Service by ID
     * @param int $id
     * @return object
     */
    public function getServiceById(int $id)
    {
        return $this->service->where('id', $id)->first();
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
            unset($data['user_id']);
            unset($data['service_category_id']);
            try {
                $entry = $this->service->create($data);
            } catch (\Throwable $th) {
                dd($th);
                flash()->addError($th->msg);
            }
            // dd($data);
        } else {

            $entry = $this->service->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry))
                $entry->update($data);
        }

        return $entry;
    }

    /**
     * Create a new Product Media
     * @param array $data
     * @return object
     */
    public function saveMedia(array $data)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            unset($data['media']);
            $service = $this->service->find($data['entities_id']);

            $file = new File;
            $file->uuid = $data['uuid'];
            $file->file_location = $data['file_location'];
            $file->file_name = $data['file_name'];
            $file->file_format = $data['file_format'];
            $file->entities_type = $data['entities_type'];
            $file->entities_id = $data['entities_id'];
            $file->save();

            try {
                // $entry = $file->products()->save($product);
                $entry = $service->files()->save($file);
            } catch (\Exception $th) {
                dd($th);
            }
        } else {
            // // $entry = $this->product->find($product)->files()->find($data['id']);
            // $data = ModelHelper::checkDefaultValues($entry, $data);
            // if (!empty($entry)
            //     $entry->update($data);
        }

        return $entry;
    }


    /**
     * Delete a service
     * @param int $id
     */
    public function destroyService(int $id)
    {
        $service = $this->service->find($id);
        $service->delete();

        return $service;
    }

    /**
     * Delete a service media
     * @param int $id
     */
    public function destroyServiceMedia(int $id)
    {
        try {
            $media = $this->file->find($id);
            $media->delete();
        } catch (\Throwable $th) {
            dd($th);
        }

        return $media;
    }
}