<?php

namespace tests;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage;


class CommonTestClass extends \PHPUnit\Framework\TestCase
{
    protected function rmDir(string $path): void
    {
        if (is_dir($this->getTestDir() . $path)) {
            rmdir($this->getTestDir() . $path);
        }
    }

    protected function rmFile(string $path): void
    {
        if (is_file($this->getTestDir() . $path)) {
            unlink($this->getTestDir() . $path);
        }
    }

    protected function mockTestFile(string $pos = '', bool $pre = true): string
    {
        return ($pre ? $this->getTestDir() : '') . 'testingFile' . $pos . '.txt';
    }

    protected function getTestDir(): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'tmp', '']);
    }
}


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


class MockKey implements Interfaces\Target\IKey
{
    public function fromSharedKey(string $key): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'tmp', $key]);
    }
}


class MockKeyFactory extends Storage\Key\Factory
{
    public function getKey(Interfaces\Target\ITarget $storage): Interfaces\Target\IKey
    {
        return new MockKey();
    }
}


class MockTargetFactory extends Storage\Target\Factory
{
    public function getStorage($params): Interfaces\Target\ITarget
    {
        return new \tests\TargetMock();
    }
}
