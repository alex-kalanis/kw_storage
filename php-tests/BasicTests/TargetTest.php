<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage;
use kalanis\kw_storage\StorageException;


class TargetTest extends CommonTestClass
{
    /**
     * @throws StorageException
     */
    public function testInit(): void
    {
        $factory = new Storage\Factory(new \MockKeyFactory(), new Storage\Target\Factory());
        $this->assertEmpty($factory->getStorage('none'));
    }

    /**
     * @throws StorageException
     */
    public function testAlreadyKnown(): void
    {
        $factory = new Storage\Factory(new \MockKeyFactory(), new Storage\Target\Factory());
        $this->assertNotEmpty($factory->getStorage(new Storage\Storage(new Storage\Key\DefaultKey(), new Storage\Target\Memory())));
    }

    /**
     * @throws StorageException
     */
    public function testVolume(): void
    {
        $factory = new Storage\Factory(new \MockKeyFactory(), new Storage\Target\Factory());
        $out1 = $factory->getStorage('volume');
        $this->assertInstanceOf(Interfaces\IPassDirs::class, $out1);
        $this->assertInstanceOf(Interfaces\IStorage::class, $out1);
        $this->assertFalse($out1->isFlat());

        $out2 = $factory->getStorage('volume::flat');
        $this->assertInstanceOf(Interfaces\IPassDirs::class, $out2);
        $this->assertInstanceOf(Interfaces\IStorage::class, $out2);
        $this->assertTrue($out2->isFlat());

        $out3 = $factory->getStorage(new \TargetMock());
        $this->assertFalse($out3 instanceof Interfaces\IPassDirs);
        $this->assertInstanceOf(Interfaces\IStorage::class, $out3);
        $this->assertFalse($out3->isFlat());
    }

    /**
     * @throws StorageException
     */
    public function testVolumeDir(): void
    {
        $volume = $this->getStorageVolume();
        // test file
        $this->assertTrue($volume->canUse());
        $this->assertFalse($volume->exists('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileOperations(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->write('dummyFile.tst', 'asdfghjklpoiuztrewqyxcvbnm'));
        $this->assertEquals('dummy mock', $volume->read('dummyFile.tst'));
        $this->assertFalse($volume->remove('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileLookup(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty(iterator_to_array($volume->lookup('dummyFile')));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertTrue($volume->increment('dummyFile.tst'));
        $this->assertFalse($volume->decrement('dummyFile.tst'));
    }

    /**
     * @throws StorageException
     */
    public function testVolumeFileHarderCounter(): void
    {
        $volume = $this->getStorageVolume();
        $this->assertEmpty($volume->removeMulti(['dummyFile.tst']));
    }

    /**
     * @throws StorageException
     * @return Interfaces\IStorage
     */
    protected function getStorageVolume(): Interfaces\IStorage
    {
        return $this->getStorageFactory()->getStorage(null);
    }

    protected function getStorageFactory(): Storage\Factory
    {
        return new Storage\Factory(new \MockKeyFactory(), new \MockTargetFactory());
    }
}
