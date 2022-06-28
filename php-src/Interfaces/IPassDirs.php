<?php

namespace kalanis\kw_storage\Interfaces;


/**
 * Interface IPassDirs
 * @package kalanis\kw_storage\Interfaces
 * When storage differs dirs and files (like normal volume)
 */
interface IPassDirs
{
    /**
     * @param string $key
     * @return bool
     */
    public function isDir(string $key): bool;
}
