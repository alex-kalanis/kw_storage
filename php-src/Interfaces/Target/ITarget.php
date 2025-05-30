<?php

namespace kalanis\kw_storage\Interfaces\Target;


use kalanis\kw_storage\StorageException;
use Traversable;


/**
 * Interface ITarget
 * @package kalanis\kw_storage\Interfaces
 * Basic operations over every simple storage
 */
interface ITarget
{
    /**
     * @param string $key
     * @return bool
     */
    public function check(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function exists(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return string
     */
    public function load(string $key): string;

    /**
     * @param string $key
     * @param string $data
     * @param int|null $timeout
     * @throws StorageException
     * @return bool
     */
    public function save(string $key, string $data, ?int $timeout = null): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function remove(string $key): bool;

    /**
     * Lookup through keys in storage
     * Passed key is full path
     * Returns only names
     * @param string $path parent node name
     * @throws StorageException
     * @return Traversable<string>
     */
    public function lookup(string $path): Traversable;

    /**
     * Increment index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function increment(string $key): bool;

    /**
     * Decrement index in key
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function decrement(string $key): bool;

    /**
     * Remove multiple keys
     * @param string[] $keys
     * @throws StorageException
     * @return array<int|string, bool>
     */
    public function removeMulti(array $keys): array;
}
