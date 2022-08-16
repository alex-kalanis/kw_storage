<?php

namespace StorageTests;


use CommonTestClass;
use kalanis\kw_storage\Extras\TVolumeCopy;


class VolumeCopyTest extends CommonTestClass
{
    public function setUp(): void
    {
        parent::setUp();
        mkdir($this->getTestDir() . 'some');
        mkdir($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any');
        touch($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'tst1');
        touch($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2');
        touch($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3');
    }

    public function tearDown(): void
    {
        // copy
        if (is_file($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'tst1')) {
            unlink($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'tst1');
        }
        if (is_file($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2')) {
            unlink($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2');
        }
        if (is_file($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3')) {
            unlink($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3');
        }
        if (is_dir($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any')) {
            rmdir($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any');
        }
        if (is_dir($this->getTestDir() . 'other')) {
            rmdir($this->getTestDir() . 'other');
        }
        // original
        if (is_file($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'tst1')) {
            unlink($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'tst1');
        }
        if (is_file($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2')) {
            unlink($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2');
        }
        if (is_file($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3')) {
            unlink($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3');
        }
        if (is_dir($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any')) {
            rmdir($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any');
        }
        if (is_dir($this->getTestDir() . 'some')) {
            rmdir($this->getTestDir() . 'some');
        }
        parent::tearDown();
    }

    public function testCopy(): void
    {
        $volume = new XVolumeCopy();
        $this->assertTrue(file_exists($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'tst1'));
        $this->assertFalse(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'tst1'));
        $this->assertTrue(file_exists($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2'));
        $this->assertFalse(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2'));
        $this->assertTrue(file_exists($this->getTestDir() . 'some' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3'));
        $this->assertFalse(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3'));
        $this->assertTrue($volume->copy($this->getTestDir() . 'some', $this->getTestDir() . 'other'));
        $this->assertTrue(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'tst1'));
        $this->assertTrue(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst2'));
        $this->assertTrue(file_exists($this->getTestDir() . 'other' . DIRECTORY_SEPARATOR . 'any' . DIRECTORY_SEPARATOR . 'tst3'));
        $this->assertFalse($volume->copy($this->getTestDir() . 'unknown', $this->getTestDir() . 'target'));
    }
}


class XVolumeCopy
{
    use TVolumeCopy;

    public function copy(string $source, string $dest): bool
    {
        return $this->xcopy($source, $dest);
    }
}

