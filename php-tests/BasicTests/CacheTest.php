<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Helper;
use kalanis\kw_storage\Storage;


class CacheTest extends CommonTestClass
{
    /**
     * @expectedException \kalanis\kw_storage\StorageException
     */
    public function testStorageUninitialized(): void
    {
        $storage = new Storage($this->getStorageFactory());
        $storage->increment('abc');
    }

    /**
     * @throws \kalanis\kw_storage\StorageException
     */
    public function testStorageInitialized(): void
    {
        Helper::initIntoStatic();
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->isConnected());
        $this->assertFalse($volume->exists('utz'));
    }

    /**
     * @throws \kalanis\kw_storage\StorageException
     */
    public function testOperations(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->set('abv', 'sdfhgdfh', null)); // must be empty timeout - enables in result - hack
        $this->assertTrue($volume->add('abv', 'dummy mock', null)); // must be same as in mock and have no timer - hack
        $this->assertEquals('dummy mock', $volume->get('abv'));
        $this->assertFalse($volume->add('abv', 'unknown', 354)); // must be different from mock
        $this->assertFalse($volume->delete('abv'));
    }

    /**
     * @throws \kalanis\kw_storage\StorageException
     */
    public function testLookup(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty(iterator_to_array($volume->getAllKeys()));
    }

    /**
     * @throws \kalanis\kw_storage\StorageException
     */
    public function testVolumeFileCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->increment($this->mockTestFile()));
        $this->assertFalse($volume->decrement($this->mockTestFile()));
    }

    /**
     * @throws \kalanis\kw_storage\StorageException
     */
    public function testVolumeFileHarderCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty($volume->deleteMulti(['dummyFile.tst']));
    }

    protected function getStorageVolume(): Storage
    {
        $storage = new Storage($this->getStorageFactory());
        $storage->init(null);
        return $storage;
    }

    protected function getStorageFactory(): Storage\Factory
    {
        return new Storage\Factory(new \MockTargetFactory(), new \MockFormatFactory(), new \MockKeyFactory());
    }
}
