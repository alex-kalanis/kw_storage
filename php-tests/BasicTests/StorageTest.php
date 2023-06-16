<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Helper;
use kalanis\kw_storage\Storage;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Translations;


class StorageTest extends CommonTestClass
{
    /**
     * @throws StorageException
     */
    public function testStorageUninitialized(): void
    {
        $storage = new Storage($this->getStorageFactory());
        $this->expectException(StorageException::class);
        $storage->increment('abc');
    }

    /**
     * @throws StorageException
     */
    public function testStorageInitialized1(): void
    {
        Helper::initStorage();
        $volume = $this->getStorageVolume1();
        $this->assertTrue($volume->isConnected());
        $this->assertFalse($volume->exists('utz'));
    }

    /**
     * @throws StorageException
     */
    public function testStorageInitialized2(): void
    {
        $volume = $this->getStorageVolume2();
        $this->assertTrue($volume->isConnected());
        $this->assertFalse($volume->exists('utz'));
    }

    /**
     * @throws StorageException
     */
    public function testOperations(): void
    {
        $volume = $this->getStorageVolume1();
        $this->assertTrue($volume->set('abv', 'sdfhgdfh', null)); // must be empty timeout - enables in result - hack
        $this->assertTrue($volume->add('abv', 'dummy mock', null)); // must be same as in mock and have no timer - hack
        $this->assertEquals('dummy mock', $volume->get('abv'));
        $this->assertFalse($volume->add('abv', 'unknown', 354)); // must be different from mock
        $this->assertFalse($volume->delete('abv'));
    }

    /**
     * @throws StorageException
     */
    public function testLookup(): void
    {
        $volume = $this->getStorageVolume1();
        $this->assertEmpty(iterator_to_array($volume->getAllKeys()));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileCounter(): void
    {
        $volume = $this->getStorageVolume1();
        $this->assertTrue($volume->increment($this->mockTestFile()));
        $this->assertFalse($volume->decrement($this->mockTestFile()));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileHarderCounter(): void
    {
        $volume = $this->getStorageVolume1();
        $this->assertEmpty($volume->deleteMulti(['dummyFile.tst']));
    }

    /**
     * @throws StorageException
     * @return Storage
     * For testing purposes that factory returns only one possible class
     */
    protected function getStorageVolume1(): Storage
    {
        $storage = new Storage($this->getStorageFactory());
        $storage->init(null);
        return $storage;
    }

    /**
     * @throws StorageException
     * @return Storage
     * For testing purposes that factory returns only one possible class
     */
    protected function getStorageVolume2(): Storage
    {
        $storage = new Storage($this->getStorageFactory(), new Translations());
        $storage->init(['something' => 'somewhere']);
        return $storage;
    }

    protected function getStorageFactory(): Storage\Factory
    {
        return new Storage\Factory(new \MockKeyFactory(), new \MockTargetFactory());
    }
}
