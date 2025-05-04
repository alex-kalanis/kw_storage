<?php

namespace tests\Support;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage;


class MockTargetFactory extends Storage\Target\Factory
{
    public function getStorage($params): Interfaces\Target\ITarget
    {
        return new \tests\Support\TargetMock();
    }
}
