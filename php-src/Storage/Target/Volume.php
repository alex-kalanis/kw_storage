<?php

namespace kalanis\kw_storage\Storage\Target;


use kalanis\kw_storage\Interfaces\IPassDirs;
use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\StorageException;
use Traversable;


/**
 * Class Volume
 * @package kalanis\kw_storage\Storage\Target
 * Store content onto volume
 */
class Volume implements IStorage, IPassDirs
{
    use TOperations;

    public function check(string $key): bool
    {
        $sepPos = mb_strrpos($key, DIRECTORY_SEPARATOR);
        $path = (false === $sepPos) ? substr($key, 0) : substr($key, 0, intval($sepPos));
        if (!is_dir($path)) {
            if (file_exists($path)) {
                unlink($path);
            }
            return mkdir($path, 0777);
        }
        return true;
    }

    public function exists(string $key): bool
    {
        return file_exists($key);
    }

    public function isDir(string $key): bool
    {
        return is_dir($key);
    }

    public function load(string $key)
    {
        $content = @file_get_contents($key);
        if (false === $content) {
            throw new StorageException('Cannot read file');
        }
        return $content;
    }

    public function save(string $key, $data, ?int $timeout = null): bool
    {
        return (false !== @file_put_contents($key, strval($data)));
    }

    public function remove(string $key): bool
    {
        return @unlink($key);
    }

    public function lookup(string $path): Traversable
    {
        $real = realpath($path);
        if (false === $real) {
            return;
        }
        $files = scandir($real);
        if (!empty($files)) {
            foreach ($files as $file) {
                yield $file;
            }
        }
    }

    public function increment(string $key, int $step = 1): bool
    {
        try {
            $number = intval($this->load($key)) + $step;
        } catch (StorageException $ex) {
            // no file
            $number = 1;
        }
        $this->remove($key); // hanging pointers
        return $this->save($key, $number);
    }

    public function decrement(string $key, int $step = 1): bool
    {
        try {
            $number = intval($this->load($key)) - $step;
        } catch (StorageException $ex) {
            // no file
            $number = 0;
        }
        $this->remove($key); // hanging pointers
        return $this->save($key, $number);
    }
}
