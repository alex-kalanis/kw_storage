<?php

namespace StorageTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Target;


class StorageTest extends CommonTestClass
{
    public function tearDown(): void
    {
        if (is_file($this->mockTestFile())) {
            unlink($this->mockTestFile());
        }
        if (is_dir($this->mockTestFile())) {
            rmdir($this->mockTestFile());
        }
        parent::tearDown();
    }

    public function testFactory(): void
    {
        $factory = new Target\Factory();
        $this->assertInstanceOf('\TargetMock', $factory->getStorage(new \TargetMock()));
        $this->assertEmpty($factory->getStorage([]));
        $this->assertInstanceOf('\kalanis\kw_storage\Storage\Target\Volume', $factory->getStorage(['storage' => 'volume']));
        $this->assertEmpty($factory->getStorage(['storage' => 'none']));
        $this->assertInstanceOf('\kalanis\kw_storage\Storage\Target\Volume', $factory->getStorage('volume'));
        $this->assertEmpty($factory->getStorage('none'));
        $this->assertEmpty($factory->getStorage('what'));
        $this->assertEmpty($factory->getStorage(null));
    }
}
