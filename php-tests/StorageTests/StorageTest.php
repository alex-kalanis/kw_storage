<?php

namespace StorageTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Target;


class StorageTest extends CommonTestClass
{
    public function tearDown(): void
    {
        $this->rmFile($this->mockTestFile('', false));
        $this->rmDir($this->mockTestFile('', false));
        parent::tearDown();
    }

    public function testFactory(): void
    {
        $factory = new Target\Factory();
        $this->assertInstanceOf(\TargetMock::class, $factory->getStorage(new \TargetMock()));
        $this->assertEmpty($factory->getStorage([]));
        $this->assertInstanceOf(Target\Volume::class, $factory->getStorage(['storage' => 'volume']));
        $this->assertEmpty($factory->getStorage(['storage' => 'none']));
        $this->assertInstanceOf(Target\Volume::class, $factory->getStorage('volume'));
        $this->assertEmpty($factory->getStorage('none'));
        $this->assertEmpty($factory->getStorage('what'));
        $this->assertEmpty($factory->getStorage(null));
    }
}
