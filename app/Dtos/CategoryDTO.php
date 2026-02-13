<?php

namespace App\Dtos;

readonly class CategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $description,
        public bool $is_active,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            is_active: $data['is_active'] ?? true,
        );
    }
}
