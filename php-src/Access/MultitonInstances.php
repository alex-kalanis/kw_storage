<?php

namespace kalanis\kw_storage\Access;


use kalanis\kw_storage\Interfaces;


/**
 * Class MultitonInstances
 * @package kalanis\kw_storage\Access
 * Multiple storages via one access point; Instances of each
 */
class MultitonInstances
{
    protected static ?MultitonInstances $instance = null;
    protected Multiton $multi;

    public static function init(?Interfaces\IStTranslations $lang = null): void
    {
        static::$instance = new self($lang);
    }

    public static function getInstance(?Interfaces\IStTranslations $lang = null): Multiton
    {
        if (empty(static::$instance)) {
            static::$instance = new self($lang);
        }
        return static::$instance->multi;
    }

    protected function __construct(?Interfaces\IStTranslations $lang = null)
    {
        $this->multi = new Multiton($lang);
    }

    /**
     * @codeCoverageIgnore singleton
     */
    private function __clone()
    {
        // cannot run
    }
}
