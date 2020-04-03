<?php

namespace App\Core;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    protected $data;

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException($id . ' must be a string');
        }

        if (!isset($this->data[$id])) {
            throw new NotFoundExceptionInterface($id);
        }
        return $this->data[$id];
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id): bool
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException($id . ' must be a string');
        }

        if (!isset($this->data[$id])) {
            return false;
        }
        return true;
    }

    /**
     * Set
     */
    public function set(string $id, $value): bool
    {
        if ($this->data[$id] = $value) {
            return true;
        }
        return false;
    }
}