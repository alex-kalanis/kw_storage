<?php

namespace tests\StorageTests;


use kalanis\kw_storage\Storage\Target;


class XFactory extends Target\Factory
{
    protected static array $pairs = [
        'memory' => Target\Memory::class,
        'none' => null,
        'not-exists' => 'this-class-does-not-exists',
    ];
}
