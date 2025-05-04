<?php

namespace tests\Support;


use kalanis\kw_storage\Interfaces;


class XStLang implements Interfaces\IStTranslations
{
    public function stCannotReadKey(): string
    {
        return 'mock';
    }

    public function stCannotReadFile(): string
    {
        return 'mock';
    }

    public function stStorageNotInitialized(): string
    {
        return 'mock';
    }

    public function stPathNotFound(): string
    {
        return 'mock';
    }

    public function stConfigurationUnavailable(): string
    {
        return 'mock';
    }
}
