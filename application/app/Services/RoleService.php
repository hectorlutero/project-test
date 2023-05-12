<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleService
{
    /**
     * @var RoleRepository
     */
    protected RoleRepository $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Select all roles
     * @return LengthAwarePaginator
     */
    public function getAll($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->roleRepository->getAllRoles($paginate, $orderField, $order);

    }

    /**
     * Filter roles
     * @return LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate): LengthAwarePaginator
    {
        return $this->roleRepository->getFilteredRole($filters, $paginate);
    }

    public function filterRoleFieldInArray($field, $array, $paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->roleRepository->filterRoleInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields(): array
    {
        return $this->roleRepository->getRoleFields();
    }

    /**
     * Select a role by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->roleRepository->getRoleById($id);
    }

    /**
     * Create a new Service
     * @param array $data
     * @return object
     */
    public function saveRoleData(array $data, array $permissions): object
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'unique:roles|required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $role = $this->roleRepository->save($data, $permissions);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update role data');
        }

        DB::commit();

        return $role;
    }

    /**
     * Delete a Service
     * @param int $id
     * @return object  response
     */
    public function delete(int $id): object
    {
        DB::beginTransaction();

        try {
            $role = $this->roleRepository->destroyRole($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete role');
        }
        DB::commit();

        return $role;
    }
}
