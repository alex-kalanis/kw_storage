<?php

namespace kalanis\kw_storage\Access;


use kalanis\kw_storage\Interfaces;
use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\Storage;
use kalanis\kw_storage\Storage\Key;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Traits\TLang;
use ReflectionClass;
use ReflectionException;


/**
 * Class Factory
 * @package kalanis\kw_storage\Access
 */
class Factory
{
    use TLang;

    /** @var array<string|int, class-string> */
    protected array $targetMap = [
        10 => Target\Memory::class,
        20 => Target\Volume::class,
        22 => Target\VolumeTargetFlat::class,
        'mem' => Target\Memory::class,
        'memory' => Target\Memory::class,
        'vol' => Target\Volume::class,
        'volume' => Target\Volume::class,
        'volume::local' => Target\Volume::class,
        'local' => Target\Volume::class,
        'volume::flat' => Target\VolumeTargetFlat::class,
    ];

    public function __construct(?Interfaces\IStTranslations $lang = null)
    {
        $this->setStLang($lang);
    }

    /**
     * @param mixed $params
     * @throws StorageException
     * @return IStorage
     */
    public function getStorage($params): IStorage
    {
        $key = $target = null;
        if (is_object($params)) {
            // IStorage -> thru
            // IKey -> select storage, return combination
            // ITarget -> select key, return combination

            if ($params instanceof IStorage) {
                return $params;

            } elseif ($params instanceof Interfaces\Target\IKey) {
                $key = $params;
                $target = $this->targetByKey($key);

            } elseif ($params instanceof Interfaces\Target\ITarget) {
                $target = $params;
                $key = new Key\DefaultKey();
            }

        } elseif (is_string($params)) {
            // string -> key as path prefix, target is always volume
            $key = $this->whichKey(['storage_key' => $params]);
            $target = new Target\Volume($this->getStLang());

        } elseif (is_array($params)) {
            if (isset($params['storage'])) {
                return $this->getStorage($params['storage']);
            }
            // array -> params decide which storage library will be initialized
            $key = $this->whichKey($params);
            $target = $this->targetByKey($key, $params);

        }
        // int, bool, etc. -> exception

        if ($key && $target) {
            if ($target instanceof Interfaces\Target\ITargetVolume) {
                return new Storage\StorageDirs($key, $target);
            }
            return new Storage\Storage($key, $target);
        }
        throw new StorageException($this->getStLang()->stConfigurationUnavailable());
    }

    /**
     * @param Interfaces\Target\IKey $key
     * @param array<string|int, string|int|float|object|bool|array<string|int|float|object>> $params
     * @throws StorageException
     * @return Interfaces\Target\ITarget
     */
    protected function targetByKey(Interfaces\Target\IKey $key, array $params = []): Interfaces\Target\ITarget
    {
        try {
            return $this->whichTarget($params);
        } catch (StorageException $ex) {
            // nothing found - use this
        }
        if ($key instanceof Key\ArrayKey) {
            return new Target\Volume($this->getStLang());
        }
        if ($key instanceof Key\DirKey) {
            return new Target\Volume($this->getStLang());
        }
        if ($key instanceof Key\StaticPrefixKey) {
            return new Target\Volume($this->getStLang());
        }
        if ($key instanceof Key\DefaultKey) {
            return new Target\Memory($this->getStLang());
        }
        throw new StorageException($this->getStLang()->stConfigurationUnavailable());
    }

    /**
     * @param array<string|int, string|int|float|object|bool|array<string|int|float|object>> $params
     * @throws StorageException
     * @return Interfaces\Target\IKey
     */
    protected function whichKey(array $params): Interfaces\Target\IKey
    {
        if (isset($params['storage_key'])) {
            if (is_object($params['storage_key'])) {
                if ($params['storage_key'] instanceof Interfaces\Target\IKey) {
                    return $params['storage_key'];
                }
                throw new StorageException($this->getStLang()->stConfigurationUnavailable());
            }
            if (is_array($params['storage_key'])) {
                $separator = DIRECTORY_SEPARATOR;
                if (isset($params['storage_delimiter'])) {
                    $separator = strval($params['storage_delimiter']);
                }
                $strArr = array_map('strval', $params['storage_key']);
                return new Key\ArrayKey($strArr, $separator);
            }
            if (is_string($params['storage_key']) && ($pt = realpath($params['storage_key']))) {
                return new Key\DirKey($pt . DIRECTORY_SEPARATOR);
            }
        }
        return new Key\DefaultKey();
    }

    /**
     * @param array<string|int, string|int|float|object|bool|array<string|int|float|object>> $params
     * @throws StorageException
     * @return Interfaces\Target\ITarget
     */
    protected function whichTarget(array $params): Interfaces\Target\ITarget
    {
        if (isset($params['storage_target'])) {
            if (is_object($params['storage_target'])) {
                if ($params['storage_target'] instanceof Interfaces\Target\ITarget) {
                    return $params['storage_target'];
                }
                throw new StorageException($this->getStLang()->stConfigurationUnavailable());
            }
            if (is_string($params['storage_target']) || is_int($params['storage_target'])) {
                if (isset($this->targetMap[$params['storage_target']])) {
                    try {
                        $reflection = new ReflectionClass($this->targetMap[$params['storage_target']]);
                        $class = $reflection->newInstance($this->getStLang());
                    } catch (ReflectionException $ex) {
                        throw new StorageException($ex->getMessage(), $ex->getCode(), $ex);
                    }
                    if ($class instanceof Interfaces\Target\ITarget) {
                        return $class;
                    } else {
                        throw new StorageException($this->getStLang()->stConfigurationUnavailable());
                    }
                }
            }
        }
        throw new StorageException($this->getStLang()->stConfigurationUnavailable());
    }
}
