<?php

namespace App\Interfaces;

use App\Dtos\CategoryDTO;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById(int $id);
    public function createCategory(CategoryDTO $data);
    public function updateCategory(int $id, CategoryDTO $data);
    public function deleteCategory(int $id);
}
