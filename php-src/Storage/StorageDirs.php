<?php

namespace kalanis\kw_storage\Storage;


use DateTimeInterface;
use kalanis\kw_storage\Interfaces;


/**
 * Class StorageDirs
 * @package kalanis\kw_storage
 * Extended storage class
 */
class StorageDirs extends Storage implements Interfaces\IPassDirs
{
    protected Interfaces\Target\ITargetVolume $targetVolume;

    public function __construct(Interfaces\Target\IKey $key, Interfaces\Target\ITargetVolume $target)
    {
        parent::__construct($key, $target);
        $this->targetVolume = $target;
    }

    public function isDir(string $key): bool
    {
        return $this->targetVolume->isDir($this->key->fromSharedKey($key));
    }

    public function isFile(string $key): bool
    {
        return $this->targetVolume->isFile($this->key->fromSharedKey($key));
    }

    public function isReadable(string $key): bool
    {
        return $this->targetVolume->isReadable($this->key->fromSharedKey($key));
    }

    public function isWritable(string $key): bool
    {
        return $this->targetVolume->isWritable($this->key->fromSharedKey($key));
    }

    public function mkDir(string $key, bool $recursive = false): bool
    {
        return $this->targetVolume->mkDir($this->key->fromSharedKey($key), $recursive);
    }

    public function rmDir(string $key, bool $recursive = false): bool
    {
        return $this->targetVolume->rmDir($this->key->fromSharedKey($key), $recursive);
    }

    public function copy(string $source, string $dest): bool
    {
        return $this->targetVolume->copy($this->key->fromSharedKey($source), $this->key->fromSharedKey($dest));
    }

    public function move(string $source, string $dest): bool
    {
        return $this->targetVolume->move($this->key->fromSharedKey($source), $this->key->fromSharedKey($dest));
    }

    public function size(string $key): ?int
    {
        return $this->targetVolume->size($this->key->fromSharedKey($key));
    }

    public function created(string $key): ?DateTimeInterface
    {
        return $this->targetVolume->created($this->key->fromSharedKey($key));
    }
}
