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

    /**
     * @param string $what
     * @param mixed $in
     * @dataProvider factoryFillProvider
     */
    public function testFactoryFill(string $what, $in): void
    {
        $factory = new Target\Factory();
        $this->assertInstanceOf($what, $factory->getStorage($in));
    }

    public function factoryFillProvider(): array
    {
        return [
            [\TargetMock::class, new \TargetMock()],
            [Target\Memory::class, ['storage' => 'mem']],
            [Target\Memory::class, ['storage' => 'memory']],
            [Target\Volume::class, ['storage' => 'vol']],
            [Target\Volume::class, ['storage' => 'volume']],
            [Target\Volume::class, ['storage' => 'local']],
            [Target\Volume::class, ['storage' => 'drive']],
            [Target\VolumeTargetFlat::class, ['storage' => 'volume::flat']],
            [Target\VolumeTargetFlat::class, ['storage' => 'local::flat']],
            [Target\VolumeTargetFlat::class, ['storage' => 'drive::flat']],
            [Target\VolumeStream::class, ['storage' => 'volume::stream']],
            [Target\VolumeStream::class, ['storage' => 'local::stream']],
            [Target\VolumeStream::class, ['storage' => 'drive::stream']],
            [Target\Memory::class, 'mem'],
            [Target\Memory::class, 'memory'],
            [Target\Volume::class, 'vol'],
            [Target\Volume::class, 'volume'],
            [Target\Volume::class, 'local'],
            [Target\Volume::class, 'drive'],
            [Target\VolumeTargetFlat::class, 'volume::flat'],
            [Target\VolumeTargetFlat::class, 'local::flat'],
            [Target\VolumeTargetFlat::class, 'drive::flat'],
            [Target\VolumeStream::class, 'volume::stream'],
            [Target\VolumeStream::class, 'local::stream'],
            [Target\VolumeStream::class, 'drive::stream'],
        ];
    }

    /**
     * @param mixed $in
     * @dataProvider factoryEmptyProvider
     */
    public function testFactoryEmpty($in): void
    {
        $factory = new Target\Factory();
        $this->assertEmpty($factory->getStorage($in));
    }

    public function factoryEmptyProvider(): array
    {
        return [
            [[]],
            [['storage' => 'none']],
            ['none'],
            ['what'],
            [null],
            [false],
        ];
    }
}
