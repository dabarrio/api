<?php

namespace App\Dtos;

readonly class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password,
        public string $role,
        public bool $is_active,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            role: $data['role'] ?? 'editor',
            is_active: $data['is_active'] ?? true,
        );
    }
}