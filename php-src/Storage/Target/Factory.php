<?php

namespace kalanis\kw_storage\Storage\Target;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Traits\TLang;
use ReflectionException;


/**
 * Class Factory
 * @package kalanis\kw_storage\Storage\Target
 * Simple example of storage factory
 */
class Factory
{
    use TLang;

    /** @var array<string, class-string<Interfaces\Target\ITarget>|null> */
    protected static array $pairs = [
        'mem' => Memory::class,
        'memory' => Memory::class,
        'vol' => Volume::class,
        'volume' => Volume::class,
        'volume::flat' => VolumeTargetFlat::class,
        'local' => Volume::class,
        'local::flat' => VolumeTargetFlat::class,
        'drive' => Volume::class,
        'drive::flat' => VolumeTargetFlat::class,
        'none' => null,
    ];

    public function __construct(?Interfaces\IStTranslations $stLang = null)
    {
        $this->setStLang($stLang);
    }

    /**
     * @param object|array<string, string|object>|string|null $params
     * @throws StorageException
     * @return Interfaces\Target\ITarget|null storage adapter or empty for no storage set
     */
    public function getStorage($params): ?Interfaces\Target\ITarget
    {
        if ($params instanceof Interfaces\Target\ITarget) {
            return $params;
        }

        try {
            if (is_array($params)) {
                if (isset($params['storage'])) {
                    if (is_object($params['storage'])) {
                        if ($params['storage'] instanceof Interfaces\Target\ITarget) {
                            return $params['storage'];
                        } else {
                            return null;
                        }
                    }
                    $lang = (isset($params['lang']) && is_object($params['lang']) && ($params['lang'] instanceof Interfaces\IStTranslations))
                        ? $params['lang']
                        : $this->getStLang();
                    return $this->fromPairs(strval($params['storage']), $lang);
                }
            }

            if (is_string($params)) {
                return $this->fromPairs(strval($params), $this->getStLang());
            }

            return null;

        } catch (ReflectionException $ex) {
            throw new StorageException($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * @param string $name
     * @param Interfaces\IStTranslations|null $lang
     * @throws ReflectionException
     * @return Interfaces\Target\ITarget|null
     */
    protected function fromPairs(string $name, ?Interfaces\IStTranslations $lang = null): ?Interfaces\Target\ITarget
    {
        if (isset(static::$pairs[$name])) {
            $class = static::$pairs[$name];
            if (is_string($class)) {
                $reflection = new \ReflectionClass($class);
                if ($reflection->isInstantiable()) {
                    $obj = $reflection->newInstance($lang);
                    if ($obj instanceof Interfaces\Target\ITarget) {
                        return $obj;
                    }
                }
            }
        }
        return null;
    }
}
