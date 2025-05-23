<?php

namespace kalanis\kw_storage\Storage\Key;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Storage\Target;


class Factory
{
    public function getKey(Interfaces\Target\ITarget $storage): Interfaces\Target\IKey
    {
        if ($storage instanceof Target\Volume) {
            return new StaticPrefixKey();
        }
        return new DefaultKey();
    }
}
