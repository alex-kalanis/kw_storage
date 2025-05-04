<?php

namespace tests\Support;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage;


class MockKeyFactory extends Storage\Key\Factory
{
    public function getKey(Interfaces\Target\ITarget $storage): Interfaces\Target\IKey
    {
        return new MockKey();
    }
}
