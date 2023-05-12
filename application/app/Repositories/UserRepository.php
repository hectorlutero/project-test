<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * UserRepository constructor
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all Users
     * @return LengthAwarePaginator
     */
    public function getAllUsers($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->user->where('id', '!=', 1)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function filterUserInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->user->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredUser($filterParams, $paginate): LengthAwarePaginator
    {
        $filtered = $this->user->query();
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
            "email",
            "phone",
            "document"
        ];
    }

    public function getUserFields(): array
    {

        $fields = [
            "name" => "input:text|size:2,attrs:required",
            "email" => "input:email|size:2,attrs:required",
            "phone" => "input:text|mask:(99) 9 9999-9999",
            "doctyperd" => "input:radio|size:2,attrs:id=document_type|opts:[pf=CPF,pj=CNPJ]",
            "cnpj" => "input:text|size:cnpj,attrs:id=cnpj_field invisible,mask:99.999.999/9999-99",
            "cpf" => "input:text|size:cpf,attrs:id=cpf_field invisible,mask:999.999.999-99",
            "roles" => "input:checkbox|size:full|opts:roles",
            "document" => "input:hidden|attrs:id=document",
            "doctype" => "input:hidden|attrs:id=doctype"
        ];

        return ["fields" => $fields];
    }

    /**
     * Get User by ID
     * @param int $id
     * @return object
     */
    public function getUserById(int $id): object
    {
        return $this->user->where('id', $id)->first();
    }

    /**
     * Create a new User
     * @param array $data
     * @return object
     */
    public function save(array $data, $roles)
    {
        $data['document'] = $data['doctyperd'] == 'pf' ? $data['cpf'] : $data['cnpj'];

        if ($data['id'] == 'new') {
            unset($data['id']);
            $roles = $data['roles'];
            unset($data['roles']);
            $entry = $this->user->create($data);
            if (!empty($roles))
                $entry->assignRole($roles);
        } else {
            $entry = $this->user->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry))
                $entry->update($data);
            if (!empty($roles))
                $entry->syncRoles($roles);
        }

        return $entry;
    }

    /**
     * Delete a service
     * @param int $id
     */
    public function destroyUser(int $id)
    {
        $user = $this->user->find($id);
        $user->delete();

        return $user;
    }
}