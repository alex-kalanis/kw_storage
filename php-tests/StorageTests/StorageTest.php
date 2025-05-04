<?php

namespace tests\StorageTests;


use tests\CommonTestClass;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Translations;


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
     * @throws StorageException
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
            [\tests\TargetMock::class, new \tests\TargetMock()],
            [Target\Memory::class, ['storage' => 'mem']],
            [Target\Memory::class, ['storage' => 'memory']],
            [Target\Memory::class, ['storage' => new Target\Memory()]],
            [Target\Memory::class, ['storage' => 'memory', 'lang' => new Translations()]],
            [Target\Volume::class, ['storage' => 'vol']],
            [Target\Volume::class, ['storage' => 'volume']],
            [Target\Volume::class, ['storage' => 'local']],
            [Target\Volume::class, ['storage' => 'drive']],
            [Target\VolumeTargetFlat::class, ['storage' => 'volume::flat']],
            [Target\VolumeTargetFlat::class, ['storage' => 'local::flat']],
            [Target\VolumeTargetFlat::class, ['storage' => 'drive::flat']],
            [Target\Memory::class, 'mem'],
            [Target\Memory::class, 'memory'],
            [Target\Volume::class, 'vol'],
            [Target\Volume::class, 'volume'],
            [Target\Volume::class, 'local'],
            [Target\Volume::class, 'drive'],
            [Target\VolumeTargetFlat::class, 'volume::flat'],
            [Target\VolumeTargetFlat::class, 'local::flat'],
            [Target\VolumeTargetFlat::class, 'drive::flat'],
        ];
    }

    /**
     * @param mixed $in
     * @throws StorageException
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
            [['storage' => new Translations()]], // not a storage
            ['none'],
            ['what'],
            [null],
            [false],
        ];
    }

    /**
     * @throws StorageException
     */
    public function testFactoryNotExists(): void
    {
        $factory = new XFactory();
        $this->expectException(StorageException::class);
        $factory->getStorage('not-exists');
    }
}


class XFactory extends Target\Factory
{
    protected static array $pairs = [
        'memory' => Target\Memory::class,
        'none' => null,
        'not-exists' => 'this-class-does-not-exists',
    ];
}
