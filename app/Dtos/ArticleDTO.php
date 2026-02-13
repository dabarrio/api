<?php

namespace App\Dtos;

readonly class ArticleDTO
{
    public function __construct(
        public string $title,
        public string $content,
        public string $slug,
        public string $status,
        public ?string $published_at,
        public int $author_id,
        public array $category_ids = [],
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            title: $data['title'],
            content: $data['content'],
            slug: $data['slug'],
            status: $data['status'],
            published_at: $data['published_at'] ?? null,
            author_id: $data['author_id'],
            category_ids: $data['category_ids'] ?? [],
        );
    }
}
