<?php

namespace tests\AccessTests;


use kalanis\kw_storage\Access;


class MultitonInstancesTest extends AAccessTest
{
    public function testRun(): void
    {
        XMuInstances::clear();
        $inst1 = XMuInstances::getInstance();
        $this->assertEquals($inst1, XMuInstances::getInstance());

        XMuInstances::init(new XStLang());
        $this->assertNotEquals($inst1, XMuInstances::getInstance());
    }
}


class XMuInstances extends Access\MultitonInstances
{
    public static function clear(): void
    {
        static::$instance = null;
    }
}
