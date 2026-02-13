<?php

namespace App\Http\Controllers;

use App\Dtos\CategoryDTO;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->categoryRepository->getAllCategories();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string',
                'is_active' => 'sometimes|boolean',
            ];

            $validatedData = $request->validate($rules);

            $dto = CategoryDTO::fromRequest($validatedData);

            return $this->categoryRepository->createCategory($dto);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try {
            return $this->categoryRepository->getCategoryById($category->id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $rules = [
                'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'sometimes|required|string',
                'is_active' => 'sometimes|boolean',
            ];

            $validatedData = $request->validate($rules);

            $dto = CategoryDTO::fromRequest($validatedData);

            return $this->categoryRepository->updateCategory($category->id, $dto);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $this->categoryRepository->deleteCategory($category->id);
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
