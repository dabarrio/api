<?php

namespace App\Repositories;

use App\Dtos\CategoryDTO;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getCategoryById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(CategoryDTO $data)
    {
        $category = Category::create([
            'name' => $data->name,
            'description' => $data->description,
            'is_active' => $data->is_active,
        ]);

        return $category;
    }

    public function updateCategory(int $id, CategoryDTO $data)
    {
        $category = $this->getCategoryById($id);

        $category->update([
            'name' => $data->name,
            'description' => $data->description,
            'is_active' => $data->is_active,
        ]);

        return $category;
    }

    public function deleteCategory(int $id)
    {
        $category = $this->getCategoryById($id);
        
        if ($category->articles()->exists()) {
            throw new \Exception('The category cannot be deleted because it has associated articles.');
        }
        
        $category->delete();
        return $category;
    }
}
