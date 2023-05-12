<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\Company;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\CompanyCategoryRepository;
use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CompanyRepository
{
    /**
     * @var Company
     * @var UserRepository
     * @var CompanyCategoryRepository
     * @var File
     */
    protected Company $company;
    protected UserRepository $userRepository;
    protected CompanyCategoryRepository $category;
    protected File $file;

    /**
     * CompanyRepository constructor
     * @param Company $company
     * @param File $file
     */
    public function __construct(Company $company, UserRepository $userRepository, CompanyCategoryRepository $category, File $file, )
    {
        $this->company = $company;
        $this->userRepository = $userRepository;
        $this->category = $category;
        $this->file = $file;
    }

    /**
     * Get all Companies
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCompanies($paginate)
    {
        return $this->company->with('user')->with('category')->with('images')->paginate($paginate);
    }

    public function filterCompanyFieldInArray($fields, $array = null, $paginate, $orderField, $order, $userId = null)
    {
        $filtered = $this->company->query();

        return $filtered->where(function ($query) use ($userId) {
            if ($userId != 1)
                return $query->where("user_id", $userId);
        })->where(function (Builder $query) use ($fields, $array) {
            foreach ($fields as $field) {
                $query->whereIn($field, $array);
            }
        })->with('logo')->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredCompanies($filterParams, $paginate, $userId = null)
    {

        $filtered = $this->company->query();
        if ($userId !== null) {
            if (empty($filterParams['term'])) {
                return $filtered->where('user_id', '=', $userId)->orderBy('companies.id')->paginate($paginate);
            }
            $fields = $this->getSearchableFields();
            $categoryFields = $this->category->getSearchableFields();
            $filtered
                ->where('user_id', '=', $userId)->where(function (Builder $query) use ($fields, $filterParams) {
                    foreach ($fields as $field) {
                        $query->orWhere('companies.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });

        } else {

            if (empty($filterParams['term'])) {
                return $filtered->orderBy('companies.id')->paginate($paginate);
            }
            $fields = $this->getSearchableFields();
            foreach ($fields as $key => $field) {
                $filtered->orWhere('companies.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
            }
            // Join with users table and search for terms in their searchable fields
            $filtered->leftJoin('users', 'companies.user_id', '=', 'users.id')
                ->orWhere(function ($query) use ($filterParams) {
                    $userFields = $this->userRepository->getSearchableFields();
                    foreach ($userFields as $key => $field) {
                        $query->orWhere('users.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });
            // TODO: APPLY FOR CATEGORIES
            // Join with company_categories table and search for terms in their searchable fields
            $filtered->leftJoin('company_categories', 'companies.company_category_id', '=', 'company_categories.id')
                ->orWhere(function ($query) use ($filterParams) {
                    $categoryFields = $this->category->getSearchableFields();
                    foreach ($categoryFields as $key => $field) {
                        $query->orWhere('company_categories.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });
        }

        return $filtered->select('companies.*')->orderBy('companies.id')->paginate($paginate);
    }

    public function getSearchableFields()
    {
        return [
            "name",
            "slug",
            "document",
            "description",
            "location",
            "zip_code",
            "state",
            "country",
            "phone",
            "email",
            "website",
            "facebook",
            "twitter",
            "linkedin",
            "pinterest",
            "youtube",
            "instagram",
        ];
    }

    public function getCompanyFields()
    {
        $model_attributes = __('model_attributes.companies');
        $fields = [
            "logo_id" => "input:file",
            "company_category_id" => "select:company_categories",
            "plan_id" => "select:plans",
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "document" => "input:text|mask:99.999.999/9999-99",
            "description" => "textarea:text",
            "location" => "input:text",
            "zip_code" => "input:text|mask:99.999-999",
            "state" => "input:text",
            "country" => "input:text",
            "phone" => "input:text|mask:99 99999-9999",
            "email" => "input:text",
            "website" => "input:text",
            "facebook" => "input:text",
            "twitter" => "input:text",
            "linkedin" => "input:text",
            "pinterest" => "input:text",
            "youtube" => "input:text",
            "instagram" => "input:text",
        ];
        $js = "dashboard/company-form.js";

        return ["model_attributes" => $model_attributes, "fields" => $fields, "js" => $js];

    }

    /**
     * Get Company by ID
     * @param int $id
     * @return object
     */
    public function getCompanyById(int $id)
    {
        return $this->company->where('id', $id)->first();
    }

    /**
     * Create a new Company
     * @param array $data
     * @param int $userId
     * @return object
     */
    public function save(array $data, int $userId = null)
    {
        if (isset($data['logo_id'])) {
            if (is_object($data['logo_id']))
                unset($data['logo_id']);
        }
        if ($userId !== null)
            $data['user_id'] = $userId;
        if ($data['id'] == 'new') {
            unset($data['id']);

            $entry = $this->company->create($data);
        } else {
            $entry = $this->company->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            try {
                if (!empty($entry)) {
                    $entry->update($data);
                }
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        return $entry;
    }

    /**
     * Delete a company
     * @param int $id
     */
    public function destroyCompany(int $id)
    {
        $company = $this->company->find($id);
        try {
            $company->delete();
        } catch (\Throwable $th) {
            dd('repository => ', $th);
            //throw $th;
        }

        return $company;
    }

    public function manageCompanyBan(int $id)
    {
        $company = $this->company->find($id);
        try {
            if ($company->status !== 'pending_approval')
                $company->status = $company->status == 'active' ? 'banned' : ($company->status == 'banned' ? 'active' : 'pending_approval');
            else
                $company->status = 'active';
            $company->save();

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            throw new \InvalidArgumentException($e->getMessage());
        }

        return true;
    }

    /**
     * Get one media Gallery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMediaGallery($id)
    {
        return $this->file->find($id);
    }
    /**
     * Get all media Gallery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGallery($id, $paginate)
    {
        return $this->company->find($id)->files()->paginate($paginate);
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
            $company = $this->company->find($data['entities_id']);
            // Set the entities_id value to the ID of the file record that you want to associate with the product
            $file = new File;
            $file->uuid = $data['uuid'];
            $file->file_location = $data['file_location'];
            $file->file_name = $data['file_name'];
            $file->file_format = $data['file_format'];
            $file->entities_type = $data['entities_type'];
            $file->entities_id = $data['entities_id'];

            $file->save();

            try {
                $entry = $company->files()->save($file);
            } catch (\Exception $th) {
                dd($th);
            }
        } else {
            unset($data['logo_id']);
            $company = $this->company->find($data['id']);
            // Set the entities_id value to the ID of the file record that you want to associate with the product
            $file = new File;
            $file->uuid = $data['uuid'];
            $file->file_location = $data['file_location'];
            $file->file_name = $data['file_name'];
            $file->file_format = $data['file_format'];
            $file->entities_type = $data['entities_type'];
            $file->entities_id = $data['id'];
            $file->save();

            try {
                $entry = $company->files()->save($file);
            } catch (\Exception $th) {
                dd($th);
            }
        }
        return $entry;
    }


    /**
     * Delete a product media
     * @param int $id
     */
    public function destroyCompanyMedia(int $id)
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