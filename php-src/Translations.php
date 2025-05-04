<?php

namespace kalanis\kw_storage;


use kalanis\kw_storage\Interfaces\IStTranslations;


/**
 * Class Translations
 * @package kalanis\kw_storage
 */
class Translations implements IStTranslations
{
    public function stCannotReadKey(): string
    {
        return 'Cannot read key';
    }

    public function stCannotReadFile(): string
    {
        return 'Cannot read file';
    }

    public function stStorageNotInitialized(): string
    {
        return 'Storage not initialized';
    }

    public function stPathNotFound(): string
    {
        return 'Path in storage not found.';
    }

    public function stConfigurationUnavailable(): string
    {
        return 'This configuration is not available.';
    }
}
