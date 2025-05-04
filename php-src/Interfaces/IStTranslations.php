<?php

namespace kalanis\kw_storage\Interfaces;


/**
 * Interface IStTranslations
 * @package kalanis\kw_storage\Interfaces
 * Translations
 */
interface IStTranslations
{
    public function stCannotReadKey(): string;

    public function stCannotReadFile(): string;

    public function stStorageNotInitialized(): string;

    public function stPathNotFound(): string;

    public function stConfigurationUnavailable(): string;
}
