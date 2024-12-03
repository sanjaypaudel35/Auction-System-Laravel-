<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {
    }

    /**
     * List all cart rules
     *
     * @param array $filterable
     * @param array $relationships
     * @return object
     */
    public function index(array $filterable, array $relationships = []): object
    {
        $users = $this->userRepository->fetchAll($filterable, $relationships);

        return $users;
    }

    /**
     * Store cart rule
     *
     * @param array $data
     * @return User
     */
    public function store(array $data): User
    {
        $data["password"] = Hash::make($data["password"]);
        $data["role_id"] = Role::where("slug", "super-admin")->first()?->id;

        $data["created_by"] = auth()->user()->id;
        $user = $this->userRepository->store($data);
        return $user;
    }

    /**
     * Show User
     *
     * @param string $userId
     * @param array $relationships
     * @return User
     */
    public function show(string $userId, array $relationships = []): User
    {
        $user = $this->userRepository->fetch($userId, $relationships);

        return $user;
    }

    /**
     * Update User
     *
     * @param string $userId
     * @param array $data
     * @return User
     */
    public function update(string $userId, array $data): User
    {
        $user = $this->userRepository->update($data, $userId);

        return $user;
    }

    /**
     * Deletes an existing cart rule
     *
     * @param string $userId
     * @return void
     */
    public function delete(string $userId): void
    {
        $this->userRepository->fetch($userId);
        $this->userRepository->delete($userId);
    }
}
