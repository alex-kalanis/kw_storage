<?php

namespace tests\AccessTests;


use kalanis\kw_storage\Access;


class XFactInstances extends Access\FactoryInstances
{
    public static function clear(): void
    {
        static::$instance = null;
    }
}
