<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getUser(int $id): User
    {
        return $this->userRepository->getUser($id);
    }

    public function create(array $data): User
    {
        return $this->userRepository->create([...$data, 'password' => bcrypt($data['password'])]);
    }

    public function update(User $user, array $data): User
    {
        return $this->userRepository->update($user, [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'] ? bcrypt($data['password']) : $user->password,
        ]);
    }
}
