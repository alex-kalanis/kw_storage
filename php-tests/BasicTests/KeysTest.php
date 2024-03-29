<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Key;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;


class KeysTest extends CommonTestClass
{
    public function testInit(): void
    {
        $factory = new Key\Factory();
        $this->assertInstanceOf(Key\StaticPrefixKey::class, $factory->getKey(new Target\Volume()));
        $this->assertInstanceOf(Key\StaticPrefixKey::class, $factory->getKey(new Target\VolumeTargetFlat()));
        $this->assertInstanceOf(Key\DefaultKey::class, $factory->getKey(new Target\Memory()));
        $this->assertInstanceOf(Key\DefaultKey::class, $factory->getKey(new \TargetMock()));
    }

    public function testDefaultKey(): void
    {
        $key = new Key\DefaultKey();
        $this->assertEquals('aaaaaaa', $key->fromSharedKey('aaaaaaa'));
        $this->assertEquals('ear/a4vw-z.7v2!3#z', $key->fromSharedKey('ear/a4vw-z.7v2!3#z'));
    }

    public function testStaticPrefixKey(): void
    {
        $key = new Key\StaticPrefixKey();
        $this->assertEquals('/var/cache/wwwcache/aaaaaaa', $key->fromSharedKey('aaaaaaa'));
        $key::setPrefix('/var/other/');
        $this->assertEquals('/var/other/ear/a4vw-z.7v2!3#z', $key->fromSharedKey('ear/a4vw-z.7v2!3#z'));
        $key::setPrefix('/var/cache/wwwcache/');
    }

    public function testArrayKey(): void
    {
        $key = new Key\ArrayKey(['another', 'target', ''], '_-_-_');
        $this->assertEquals('another_-_-_target_-_-_aaaaaaa', $key->fromSharedKey('aaaaaaa'));
    }

    public function testDirKey(): void
    {
        $key = new Key\DirKey('another---target---');
        $this->assertEquals('another---target---aaaaaaa', $key->fromSharedKey('aaaaaaa'));
    }

    /**
     * @throws StorageException
     */
    public function testArrayDirKeyPass(): void
    {
        $key = new Key\ArrayDirKey([__DIR__, '..', 'data']);
        $this->assertNotEmpty($key->fromSharedKey('aaaaaaa'));
    }

    public function testArrayDirKeyFail(): void
    {
        $this->expectException(StorageException::class);
        new Key\ArrayDirKey(['not-a-path']);
    }
}
