<?php

namespace tests\AccessTests;


use kalanis\kw_storage\Access;


class XMuInstances extends Access\MultitonInstances
{
    public static function clear(): void
    {
        static::$instance = null;
    }
}
