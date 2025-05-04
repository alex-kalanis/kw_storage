<?php

namespace tests\TraitsTests;


use tests\CommonTestClass;
use kalanis\kw_storage\Interfaces\IStTranslations;
use kalanis\kw_storage\Traits\TLang;
use kalanis\kw_storage\Translations;


class LangTest extends CommonTestClass
{
    public function testSimple(): void
    {
        $lib = new XLang();
        $this->assertNotEmpty($lib->getStLang());
        $this->assertInstanceOf(Translations::class, $lib->getStLang());
        $lib->setStLang(new XTrans());
        $this->assertInstanceOf(XTrans::class, $lib->getStLang());
        $lib->setStLang(null);
        $this->assertInstanceOf(Translations::class, $lib->getStLang());
    }
}


class XLang
{
    use TLang;
}


class XTrans implements IStTranslations
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
