<?php

namespace kalanis\kw_storage\Storage\Target;


use kalanis\kw_storage\StorageException;


/**
 * Class VolumeStream
 * @package kalanis\kw_storage\Storage\Target
 * Store content onto volume - streams
 */
class VolumeStream extends Volume
{
    /**
     * @param string $key
     * @throws StorageException
     * @return resource
     */
    public function load(string $key)
    {
        $content = @fopen($key, 'rb');
        $data = @fopen('php://temp', 'r+b');
        if ((false === $content) || (false === $data)) {
            throw new StorageException('Cannot read file');
        }
        if (false === @stream_copy_to_stream($content, $data)) {
            throw new StorageException('Cannot read file');
        }
        if (false === @fclose($content)) {
            throw new StorageException('Cannot close opened file');
        }
        return $data;
    }

    /**
     * @param string $key
     * @param resource $data
     * @param int|null $timeout
     * @throws StorageException
     * @return bool
     */
    public function save(string $key, $data, ?int $timeout = null): bool
    {
        $content = @fopen($key, 'wb');
        if (false === $content) {
            throw new StorageException('Cannot open file');
        }
        if (false === @stream_copy_to_stream($data, $content, -1, 0)) {
            throw new StorageException('Cannot save file');
        }
        if (-1 === @fseek($content, 0)) {
            throw new StorageException('Cannot seek in file');
        }
        if (false === @fclose($content)) {
            throw new StorageException('Cannot close opened file');
        }
        return true;
    }
}
