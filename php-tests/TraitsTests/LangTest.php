<?php

namespace tests\TraitsTests;


use kalanis\kw_storage\Translations;
use tests\CommonTestClass;
use tests\Support\XStLang;


class LangTest extends CommonTestClass
{
    public function testSimple(): void
    {
        $lib = new XLang();
        $this->assertNotEmpty($lib->getStLang());
        $this->assertInstanceOf(Translations::class, $lib->getStLang());
        $lib->setStLang(new XStLang());
        $this->assertInstanceOf(XStLang::class, $lib->getStLang());
        $lib->setStLang(null);
        $this->assertInstanceOf(Translations::class, $lib->getStLang());
    }
}
