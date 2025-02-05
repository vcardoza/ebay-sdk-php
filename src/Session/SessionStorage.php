<?php

declare(strict_types=1);

namespace Cardoza\Ebay\Session;

use function session_start;
use function session_status;
use const PHP_SESSION_NONE;

class SessionStorage implements SessionInterface
{
    private array $storage = [];

    /**
     * Initializes a new instance of the SessionStorage class.
     *
     * Starts a session if none exists and initializes the session storage.
     *
     * @param array $options An optional array of session options.
     *
     * @throws \RuntimeException If the session fails to start.
     */

    public function __construct(array $options = [])
    {
        if (session_status() === PHP_SESSION_NONE) {
            if (!session_start($options)) {
                throw new \Exception('Failed to start session');
            }
        }

        $this->storage = &$_SESSION;
    }

    /**
     * Retrieves a value from the session storage.
     *
     * @param string $key The key under which the value is stored.
     * @param mixed $default The default value to return if the key does not exist.
     *
     * @return string|array|null The value associated with the given key, or the default if it does not exist.
     */
    public function get(string $key, $default = null): mixed
    {
        return $this->storage[$key] ?? $default;
    }

    /**
     * Sets a value in the session storage.
     *
     * @param string $key The key under which the value is stored.
     * @param string $value The value to store in the session.
     *
     * @return void
     */

    public function set(string $key, mixed $value): void
    {
        $this->storage[$key] = $value;
    }
    /**
     * Deletes the given key from the session storage.
     *
     * @param string $key The key to delete.
     */
    public function delete(string $key): void
    {
        unset($this->storage[$key]);
    }

    /**
     * Determines if the given key exists in the session storage.
     *
     * @param string $key The key to check.
     *
     * @return bool True if the key exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return isset($this->storage[$key]);
    }
}
