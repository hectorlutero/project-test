<?php
namespace App\Repositories;

use App\Helpers\ModelHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository
{
    /**
     * @var Role
     */
    protected Role $role;

    /**
     * RoleRepository constructor
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get all Roles
     * @return LengthAwarePaginator
     */
    public function getAllRoles($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->role->where('id', '!=', 1)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function filterRoleInArray($field, $array, $paginate, $orderField, $order)
    {
        $filtered = $this->role->query();
        return $filtered->whereIn($field, $array)->orderBy($orderField, $order)->paginate($paginate);
    }

    public function getFilteredRole($filterParams, $paginate): LengthAwarePaginator
    {
        $filtered = $this->role->query();
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
        ];
    }

    public function getRoleFields(): array
    {

        $fields = [
            "name" => "input:text|size:2,attrs:required",
            "permissions" => "input:checkbox|size:full,attrs:permissions|opts:permissions"
        ];

        return ["fields" => $fields];
    }

    /**
     * Get Role by ID
     * @param int $id
     * @return object
     */
    public function getRoleById(int $id): object
    {
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return $this->role->where('id', $id)->first();
    }

    /**
     * Create a new Role
     * @param array $data
     * @return object
     */
    public function save(array $data, $permissions)
    {
        if ($data['id'] == 'new') {
            unset($data['id']);
            $data['guard_name'] = 'web';
            $entry = $this->role->create($data);
            if (!empty($permissions)) $entry->givePermissionTo($permissions);
        } else {
            $entry = $this->role->find($data['id']);
            $data = ModelHelper::checkDefaultValues($entry, $data);
            if (!empty($entry)) $entry->update($data);
            if(!empty($permissions)) $entry->syncPermissions($permissions);
        }

        return $entry;
    }

    /**
     * Delete a service
     * @param int $id
     */
    public function destroyRole(int $id)
    {
        $role = $this->role->find($id);
        $role->delete();

        return $role;
    }
}
