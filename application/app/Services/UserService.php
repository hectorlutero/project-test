<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserService
{
    /**
     * @var UserRepository
     */
    protected UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Select all roles
     * @param $paginate
     * @param $orderField
     * @param $order
     * @return LengthAwarePaginator
     */
    public function getAll($paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->userRepository->getAllUsers($paginate, $orderField, $order);

    }

    /**
     * Filter roles
     * @return LengthAwarePaginator
     */
    public function getFiltered($filters, $paginate): LengthAwarePaginator
    {
        return $this->userRepository->getFilteredUser($filters, $paginate);
    }

    public function filterUserFieldInArray($field, $array, $paginate, $orderField, $order): LengthAwarePaginator
    {
        return $this->userRepository->filterUserInArray($field, $array, $paginate, $orderField, $order);
    }

    public function getFields(): array
    {
        return $this->userRepository->getUserFields();
    }

    /**
     * Select a role by ID
     * @param int $id
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * Create a new User
     * @param array $data
     * @param array $roles
     * @return object
     */
    public function saveUserData(array $data, array $roles): object
    {
        if ($data['id'] == 'new') {
            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'unique:users|required'
            ]);

            if ($validator->fails()) {
                throw new \InvalidArgumentException($validator->errors()->first());
            }
        }

        DB::beginTransaction();

        try {
            $data = array_filter($data);
            $role = $this->userRepository->save($data, $roles);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new \InvalidArgumentException('Unable to update user data');
        }

        DB::commit();

        return $role;
    }

    /**
     * Delete a User
     * @param int $id
     * @return object  response
     */
    public function delete(int $id): object
    {
        DB::beginTransaction();

        try {
            $role = $this->userRepository->destroyUser($id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new \InvalidArgumentException('Unable to delete user');
        }
        DB::commit();

        return $role;
    }
}
