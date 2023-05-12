<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\Product;
use App\Models\File;
use App\Models\User;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

use stdClass;
use Illuminate\Support\Str;

class ProductRepository
{
    /**
     * @var Product
     * @var CompanyRepository
     * @var File
     */
    protected $product;
    protected $company;
    protected $file;

    /**
     * ProductRepository constructor
     * @param Product $product
     * @param CompanyRepository $company
     * @param File $file
     */
    public function __construct(Product $product, CompanyRepository $company, File $file)
    {
        $this->product = $product;
        $this->company = $company;
        $this->file = $file;
    }

    /**
     * Get all Products
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProducts($paginate)
    {

        return $this->product->with('company')->with('files')->paginate($paginate);
    }


    public function filterProductFieldInArray($field, $array, $paginate, $orderField, $order, $companyId = null, $userId = null)
    {
        $filtered = $this->product->query();
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


    public function getFilteredProducts($filterParams, $paginate, $userId = null)
    {
        $filtered = $this->product->query();


        $fields = $this->getSearchableFields();
        if ($userId !== null) {
            if (empty($filterParams['term'])) {
                if (empty($filterParams['search_by_field'])) {
                    $filtered->leftJoin('companies', 'products.company_id', '=', 'companies.id')
                        ->where('companies.user_id', '=', $userId);
                    return $filtered->select('products.*')->orderBy('products.id')->paginate($paginate);
                } else {
                    $requestedField = $filterParams['search_by_field'];
                    $fields = $this->getSearchableFields();
                    $filtered->leftJoin('companies', 'products.company_id', '=', 'companies.id')
                        ->where('companies.user_id', '=', $userId);
                    foreach ($fields as $field) {
                        if ($field === $requestedField[0])
                            $filtered->orWhere('products.' . $field, 'LIKE', "%" . $requestedField[1] . "%");
                    }
                    return $filtered->select('products.*')->orderBy('products.id')->paginate($paginate);
                }
            }


            $filtered
                ->leftJoin('companies', 'products.company_id', '=', 'companies.id')
                ->where('companies.user_id', '=', $userId)
                ->where(function (Builder $query) use ($fields, $filterParams) {
                    foreach ($fields as $field) {
                        $query->orWhere('products.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
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
                            $filtered->orWhere('products.' . $field, 'LIKE', "%" . $requestedField[1] . "%");
                    }
                    return $filtered->orderBy('id')->paginate($paginate);
                }
            }

            $filtered->leftJoin('companies', 'products.company_id', '=', 'companies.id')
                ->where(function ($query) use ($filterParams) {
                    $userFields = $this->company->getSearchableFields();
                    foreach ($userFields as $key => $field) {
                        $query->orWhere('companies.' . $field, 'LIKE', "%" . $filterParams['term'] . "%");
                    }
                });
        }

        return $filtered->select('products.*')->orderBy('id')->paginate($paginate);
    }


    public function getSearchableFields()
    {
        return [
            "name",
            "slug",
            "description",
            "model",
            "sku",
            "price",
            "status",
            "stock",
            "company_id",
        ];
    }

    public function getProductFields()
    {

        $fields = [
            // "user_id" => "select:users",
            // "company_id" => "select:companies",
            "product_category_id" => "select:product_categories",
            "name" => "input:text|size:2",
            "slug" => "input:text|size:2",
            "description" => "textarea:text",
            "model" => "input:text",
            "sku" => "input:text",
            "stock" => "input:number",
            "price" => "input:text",
        ];
        $js = "dashboard/product-form.js";


        return ["fields" => $fields, "js" => $js];

    }

    /**
     * Get Product by ID
     * @param int $id
     * @return object
     */
    public function getProductById(int $id)
    {
        return $this->product->where('id', $id)->first();
    }

    /**
     * Create a new Product
     * @param array $data
     * @return object
     */
    public function save(array $data)
    {
        if ($data['id'] == 'new') {

            unset($data['id']);
            // TODO: Make connection between product_id and product_category_id
            if (isset($data['product_category_id'])) {
                unset($data['product_category_id']);
            }
            $data['slug'] = Str::of($data['slug'])->slug('-')->value();
            $data['price'] = (double) $data['price'];
            $data['stock'] = intval($data['stock']);
            $data['company_id'] = intval($data['company_id']);

            try {
                $entry = $this->product->create($data);
            } catch (\Throwable $th) {
                dd($th);
            }

        } else {
            $entry = $this->product->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry))
                $entry->update($data);
        }

        return $entry;
    }

    /**
     * Delete a product
     * @param int $id
     */
    public function destroyProduct(int $id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return $product;
    }

    /**
     * Get all media Gallery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGallery($id, $paginate)
    {
        return $this->product->find($id)->files()->paginate($paginate);
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
            $product = $this->product->find($data['entities_id']);

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
                // $entry = $file->products()->save($product);
                $entry = $product->files()->save($file);
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
     * Delete a product media
     * @param int $id
     */
    public function destroyProductMedia(int $id)
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