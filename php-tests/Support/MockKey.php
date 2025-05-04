<?php

namespace tests\Support;


use kalanis\kw_storage\Interfaces;


class MockKey implements Interfaces\Target\IKey
{
    public function fromSharedKey(string $key): string
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'tmp', $key]);
    }
}
