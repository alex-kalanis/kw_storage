<?php

namespace TraitsTests;


use kalanis\kw_storage\Interfaces\IStTranslations;
use kalanis\kw_storage\Traits\TLang;
use kalanis\kw_storage\Translations;


class LangTest extends \CommonTestClass
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

    public function stCannotOpenFile(): string
    {
        return 'mock';
    }

    public function stCannotSaveFile(): string
    {
        return 'mock';
    }

    public function stCannotSeekFile(): string
    {
        return 'mock';
    }

    public function stCannotCloseFile(): string
    {
        return 'mock';
    }

    public function stStorageNotInitialized(): string
    {
        return 'mock';
    }
}
