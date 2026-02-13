<?php

namespace App\Repositories;

use App\Dtos\UserDTO;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function createUser(UserDTO $data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'role' => $data->role,
            'is_active' => $data->is_active,
        ]);

        return $user;
    }

    public function updateUser(int $id, UserDTO $data)
    {
        $user = $this->getUserById($id);

        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'role' => $data->role,
            'is_active' => $data->is_active,
        ]);

        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = $this->getUserById($id);
        $user->delete();
        return $user;
    }
}
