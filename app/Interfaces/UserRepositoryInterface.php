<?php

namespace App\Interfaces;

use App\Dtos\UserDTO;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById(int $id);
    public function createUser(UserDTO $data);
    public function updateUser(int $id, UserDTO $data);
    public function deleteUser(int $id);
}