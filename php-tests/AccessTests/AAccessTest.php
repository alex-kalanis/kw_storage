<?php

namespace tests\AccessTests;


use tests\CommonTestClass;
use kalanis\kw_storage\Interfaces;


abstract class AAccessTest extends CommonTestClass
{
}


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
