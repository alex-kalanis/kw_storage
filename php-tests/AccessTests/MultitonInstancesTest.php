<?php

namespace tests\AccessTests;


use tests\CommonTestClass;
use tests\Support\XStLang;


class MultitonInstancesTest extends CommonTestClass
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
