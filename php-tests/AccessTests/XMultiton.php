<?php

namespace tests\AccessTests;


use kalanis\kw_storage\Access;


class XMultiton extends Access\Multiton
{
    public function clear(): void
    {
        $this->instances = [];
    }
}
