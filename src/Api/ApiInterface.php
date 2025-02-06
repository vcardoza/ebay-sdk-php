<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Api;

interface ApiInterface
{
    public function getAll(): array;
    public function getById(string $id): array;
}
