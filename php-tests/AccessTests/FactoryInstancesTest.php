<?php

namespace AccessTests;


use kalanis\kw_storage\Access;


class FactoryInstancesTest extends AAccessTest
{
    public function testRun(): void
    {
        XFactInstances::clear();
        $inst1 = XFactInstances::getInstance();
        $this->assertEquals($inst1, XFactInstances::getInstance());

        XFactInstances::init(new XStLang());
        $this->assertNotEquals($inst1, XFactInstances::getInstance());
    }
}


class XFactInstances extends Access\FactoryInstances
{
    public static function clear(): void
    {
        static::$instance = null;
    }
}
