<?php

namespace tests\AccessTests;


use kalanis\kw_storage\StorageException;
use tests\CommonTestClass;


class MultitonTest extends CommonTestClass
{
    /**
     * Call with already known params - it reuse known class and connection underneath
     * @throws StorageException
     */
    public function testRunEquals(): void
    {
        $lib = new XMultiton();
        $inst1 = $lib->lookup(['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'mem']);
        $this->assertEquals($inst1, $lib->lookup(['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'mem']));
        $this->assertNotEquals($inst1, $lib->lookup(['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'volume']));
    }

    /**
     * Not need to call params again - they are already known in that alias
     * @throws StorageException
     */
    public function testRunEqualsAliases(): void
    {
        $lib = new XMultiton();
        $inst1 = $lib->lookup(['storage_key' => [__DIR__, '..', 'data'], 'storage_target' => 'mem'], 'first');
        $this->assertEquals($inst1, $lib->lookup([], 'first'));
    }
}
