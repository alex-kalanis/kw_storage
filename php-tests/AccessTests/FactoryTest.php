<?php

namespace AccessTests;


use CommonTestClass;
use kalanis\kw_storage\Access;
use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Storage\Key;
use kalanis\kw_storage\Storage\Storage;
use kalanis\kw_storage\Storage\Target;


class FactoryTest extends CommonTestClass
{
    /**
     * @param $param
     * @throws StorageException
     * @dataProvider passProvider
     */
    public function testPass($param): void
    {
        $lang = null;
        if (is_array($param) && isset($param['xlang']) && ($param['xlang'] instanceof Interfaces\IStTranslations)) {
            $lang = $param['xlang'];
        }
        $lib = new Access\Factory($lang);
        $this->assertInstanceOf(Interfaces\IStorage::class, $lib->getStorage($param));
    }

    /**
     * @throws StorageException
     * @return array
     */
    public function passProvider(): array
    {
        return [
            [new Storage(new Key\DefaultKey(), new Target\Memory())], // IStorage - already known
            [new Key\ArrayKey([])], // IKey -> default out
            [new Key\DirKey(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR)], // IKey -> default out
            [new Key\StaticPrefixKey()], // IKey -> default out
            [new Key\DefaultKey()], // IKey -> default out
            [new Target\Memory()], // ITarget -> default out

            [__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data'], // path to dir
            [['storage_key' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data']], // path to dir
            [['storage_key' => new Key\DefaultKey() ]], // IKey -> predefined
            [['storage_key' => [__DIR__, '..', 'data']]], // path to dir as array
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_delimiter' => '____']], // path to dir as array, custom delimiter

            [['storage_key' => '..' . DIRECTORY_SEPARATOR . 'data']], // not a valid path, yet it runs
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => new Target\Memory()]], // path to dir as array, target set
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => new \stdClass()]], // path to dir as array, target shit
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'volume']], // path to dir as array, target set
            [['storage' => ['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 99]]], // path to dir as array, target shit
        ];
    }

    /**
     * @param mixed $param
     * @throws StorageException
     * @dataProvider failProvider
     */
    public function testFail($param): void
    {
        $lib = new Access\Factory();
        $this->expectException(StorageException::class);
        $lib->getStorage($param);
    }

    /**
     * @throws StorageException
     * @return array<object|string|int|bool|null|array<string|int, object|string|int|bool|null>>
     */
    public function failProvider(): array
    {
        return [
            [true],
            [false],
            [null],
            [new \stdClass()],
            [new Key\ArrayDirKey([__DIR__, '..', 'data'])], // IKey -> failed one with no representation in lookup
            [['storage_key' => new \stdClass() ]], // not IKey
        ];
    }

    /**
     * @param mixed $param
     * @throws StorageException
     * @dataProvider crashProvider
     */
    public function testCrashRecovery($param): void
    {
        $lib = new XFailFactory();
        $this->assertInstanceOf(Interfaces\IStorage::class, $lib->getStorage($param));
    }

    /**
     * @return array<object|string|int|bool|null|array<string|int, object|string|int|bool|null>>
     */
    public function crashProvider(): array
    {
        return [
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'class']],
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'null']],
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'not-target']],
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 786]],
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 8080]],
            [['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 6060]],
        ];
    }
}


class XFailFactory extends Access\Factory
{
    protected $targetMap = [
        'class' => \stdClass::class,
        'null' => null,
        'not' => 'not-a-class',
        'not-target' => XNotTarget::class,
        8080 => \stdClass::class,
        9090 => null,
        6060 => 'not-a-class',
        5050 => XNotTarget::class,
    ];
}


class XNotTarget
{
    public function __construct(Interfaces\IStTranslations $tr)
    {
    }
}
