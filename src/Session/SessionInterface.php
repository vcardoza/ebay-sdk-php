<?php

declare(strict_types=1);

namespace Cardoza\EbaySdk\Session;

/**
 * Interface SessionInterface
 * 
 * Represents a session storage interface.
 */
interface SessionInterface
{
    public function get(string $key, $default = null): mixed;
    public function set(string $key, mixed $value): void;
    public function delete(string $key): void;
    public function has(string $key): bool;
}
