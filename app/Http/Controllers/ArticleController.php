<?php

namespace App\Http\Controllers;

use App\Dtos\ArticleDTO;
use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return $this->articleRepository->getAllArticles();
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
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'status' => 'required|in:draft,published,archived',
                'published_at' => 'nullable|date',
                'author_id' => 'required|exists:users,id',
                'category_ids' => 'array',
                'category_ids.*' => 'exists:categories,id',
            ];

            $validatedData = $request->validate($rules);

            $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title']);

            $dto = ArticleDTO::fromRequest($validatedData);

            return $this->articleRepository->createArticle($dto);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try {
            return $this->articleRepository->getArticleById($article->id);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $rules = [
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'status' => 'sometimes|required|in:draft,published,archived',
                'published_at' => 'nullable|date',
                'author_id' => 'sometimes|required|exists:users,id',
                'category_ids' => 'array',
                'category_ids.*' => 'exists:categories,id',
            ];

            $validatedData = $request->validate($rules);

            if (isset($validatedData['title'])) {
                $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title'], $article->id);
            }

            $dto = ArticleDTO::fromRequest($validatedData);

            return $this->articleRepository->updateArticle($article->id, $dto);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $this->articleRepository->deleteArticle($article->id);
            return response()->json(['message' => 'Article deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Article::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
