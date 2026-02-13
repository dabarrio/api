<?php

namespace App\Repositories;

use App\Models\Article;
use App\Dtos\ArticleDTO;
use App\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getAllArticles()
    {
        return Article::with('categories')->get();
    }

    public function getArticleById(int $id)
    {
        return Article::findOrFail($id);
    }

    public function createArticle(ArticleDTO $data)
    {
        $article = Article::create([
            'title' => $data->title,
            'content' => $data->content,
            'slug' => $data->slug,
            'status' => $data->status,
            'published_at' => $data->published_at,
            'author_id' => $data->author_id,
        ]);

        if (!empty($data->category_ids)) {
            $article->categories()->sync($data->category_ids);
        }

        return $article;
    }

    public function updateArticle(int $id, ArticleDTO $data)
    {
        $article = $this->getArticleById($id);
        $article->update([
            'title' => $data->title,
            'content' => $data->content,
            'slug' => $data->slug,
            'status' => $data->status,
            'published_at' => $data->published_at,
            'author_id' => $data->author_id,
        ]);

        if (!empty($data->category_ids)) {
            $article->categories()->sync($data->category_ids);
        }

        return $article;
    }

    public function deleteArticle(int $id)
    {
        $article = $this->getArticleById($id);
        $article->delete();
        return $article;
    }
}
