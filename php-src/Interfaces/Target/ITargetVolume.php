<?php

namespace kalanis\kw_storage\Interfaces\Target;


use DateTimeInterface;
use kalanis\kw_storage\StorageException;


/**
 * Interface ITargetVolume
 * @package kalanis\kw_storage\Interfaces
 * When storage pass on volume dirs and files
 */
interface ITargetVolume extends ITarget
{
    /**
     * @param string $key
     * @return bool
     */
    public function isDir(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function isFile(string $key): bool;

    /**
     * @param string $key
     * @return bool
     */
    public function isReadable(string $key): bool;

    /**
     * @param string $key
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
     * @return int<0, max>|null
     */
    public function size(string $key): ?int;

    /**
     * Get when node has been created
     * null if not exists or cannot get that info
     * @param string $key
     * @return DateTimeInterface|null
     */
    public function created(string $key): ?DateTimeInterface;
}
