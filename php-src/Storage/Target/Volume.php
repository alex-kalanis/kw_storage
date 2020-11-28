<?php

namespace kalanis\kw_storage\Storage\Target;


use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\StorageException;
use Traversable;


/**
 * Class Volume
 * @package kalanis\kw_storage\Storage\Target
 * Store content onto volume
 */
class Volume implements IStorage
{
    public function check(string $key): bool
    {
        $path = substr($key, 0, strrpos($key, DIRECTORY_SEPARATOR));
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
        return is_file($key);
    }

    public function load(string $key): string
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

    public function lookup(string $key): Traversable
    {
        $path = realpath($key);
        if (false === $path) {
            return;
        }
        foreach (scandir($path) as $file) {
            if (is_file($key . $file)) {
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

    public function removeMulti(array $keys): array
    {
        $result = [];
        foreach ($keys as $index => $key) {
            $result[$index] = $this->remove($key);
        }
        return $result;
    }
}
