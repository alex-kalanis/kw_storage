<?php

namespace tests\AccessTests;


use kalanis\kw_storage\Access;


class XFailFactory extends Access\Factory
{
    protected array $targetMap = [
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
