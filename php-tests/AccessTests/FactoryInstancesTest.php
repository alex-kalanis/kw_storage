<?php

namespace tests\AccessTests;


use tests\CommonTestClass;
use tests\Support\XStLang;


class FactoryInstancesTest extends CommonTestClass
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
