<?php

namespace tests;


abstract class CommonTestClass extends \PHPUnit\Framework\TestCase
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
