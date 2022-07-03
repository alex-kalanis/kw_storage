<?php

namespace kalanis\kw_storage\Interfaces;


use kalanis\kw_storage\StorageException;


/**
 * Interface IPassDirs
 * @package kalanis\kw_storage\Interfaces
 * When storage differs dirs and files (like normal volume)
 */
interface IPassDirs
{
    /**
     * @param string $key
     * @return bool
     */
    public function isDir(string $key): bool;

    /**
     * Create subdir
     * @param string $key
     * @param bool $recursive
     * @throws StorageException
     * @return bool
     */
    public function mkDir(string $key, bool $recursive = false): bool;

    /**
     * Remove subdir
     * @param string $key
     * @param bool $recursive
     * @throws StorageException
     * @return bool
     */
    public function rmDir(string $key, bool $recursive = false): bool;
}
