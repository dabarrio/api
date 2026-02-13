<?php

namespace App\Interfaces;

use App\Dtos\ArticleDTO;

interface ArticleRepositoryInterface
{
    public function getAllArticles();
    public function getArticleById(int $id);
    public function createArticle(ArticleDTO $data);
    public function updateArticle(int $id, ArticleDTO $data);
    public function deleteArticle(int $id);
}
