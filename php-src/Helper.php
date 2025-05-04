<?php

namespace kalanis\kw_storage;


use kalanis\kw_storage\Interfaces\IStorage;
use kalanis\kw_storage\Interfaces\IStTranslations;


/**
 * Class Helper
 * @package kalanis\kw_storage
 * Create cache with already known settings
 */
class Helper
{
    public static function initStorage(?IStTranslations $lang = null): Storage
    {
        return new Storage(static::initFactory($lang), $lang);
    }

    public static function initFactory(?IStTranslations $lang = null): Storage\Factory
    {
        return new Storage\Factory(
            new Storage\Key\Factory(),
            new Storage\Target\Factory($lang)
        );
    }

    /**
     * @param array<string|int, string|int|float|object|bool|array<string|int|float|object>>|string|object|int|bool|null $params
     * @param IStTranslations|null $lang
     * @throws StorageException
     * @return IStorage
     */
    public static function getStorage($params, ?IStTranslations $lang = null): IStorage
    {
        return (new Access\Factory($lang))->getStorage($params);
    }

    /**
     * @param array<string|int, string|int|float|object|bool|array<string|int|float|object>>|string|object|int|bool|null $params
     * @param string|null $alias
     * @param IStTranslations|null $lang
     * @throws StorageException
     * @return IStorage
     */
    public static function getMultiStorage($params, ?string $alias = null, ?IStTranslations $lang = null): IStorage
    {
        return Access\MultitonInstances::getInstance($lang)->lookup($params, $alias);
    }
}
