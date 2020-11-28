<?php

namespace kalanis\kw_storage\Storage\Key;


use kalanis\kw_storage\Interfaces\IKey;


class DirKey implements IKey
{
    /**
     * @param string $key channel Id
     * @return string
     * /var/cache/wwwcache - coming from cache check
     */
    public function fromSharedKey(string $key): string
    {
        return '/var/cache/wwwcache/' . $key;
    }
}
