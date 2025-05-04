<?php

namespace tests\Support;


use kalanis\kw_storage\Interfaces;


class TargetMock implements Interfaces\Target\ITarget
{
    public function check(string $key): bool
    {
        return true;
    }

    public function exists(string $key): bool
    {
        return false;
    }

    public function load(string $key): string
    {
        return 'dummy mock';
    }

    public function save(string $key, string $data, ?int $timeout = null): bool
    {
        return empty($timeout);
    }

    public function remove(string $key): bool
    {
        return false;
    }

    public function lookup(string $path): \Traversable
    {
        yield from [];
    }

    public function increment(string $key): bool
    {
        return true;
    }

    public function decrement(string $key): bool
    {
        return false;
    }

    public function removeMulti(array $keys): array
    {
        return [];
    }
}
