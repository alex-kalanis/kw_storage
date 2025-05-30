<?php

namespace kalanis\kw_storage\Interfaces;


use DateTimeInterface;
use kalanis\kw_storage\StorageException;


/**
 * Interface IPassDirs
 * @package kalanis\kw_storage\Interfaces
 * When storage differs dirs and files (like normal volume)
 */
interface IPassDirs extends IStorage
{
    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function isDir(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function isFile(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function isReadable(string $key): bool;

    /**
     * @param string $key
     * @throws StorageException
     * @return bool
     */
    public function isWritable(string $key): bool;

    /**
     * Create subdirectory
     * @param string $key
     * @param bool $recursive
     * @throws StorageException
     * @return bool
     */
    public function mkDir(string $key, bool $recursive = false): bool;

    /**
     * Remove subdirectory
     * @param string $key
     * @param bool $recursive
     * @throws StorageException
     * @return bool
     */
    public function rmDir(string $key, bool $recursive = false): bool;

    /**
     * Copy dirs and files
     * @param string $source
     * @param string $dest
     * @throws StorageException
     * @return bool
     */
    public function copy(string $source, string $dest): bool;

    /**
     * Move dirs and files
     * @param string $source
     * @param string $dest
     * @throws StorageException
     * @return bool
     */
    public function move(string $source, string $dest): bool;

    /**
     * Get node size
     * null if not exists or cannot determine (dir)
     * @param string $key
     * @throws StorageException
     * @return int<0, max>|null
     */
    public function size(string $key): ?int;

    /**
     * Get when node has been created
     * null if not exists or cannot get that info
     * @param string $key
     * @throws StorageException
     * @return DateTimeInterface|null
     */
    public function created(string $key): ?DateTimeInterface;
}
