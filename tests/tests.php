<?php

class Tests extends PHPUnit_Framework_TestCase
{
    public function test1() {
        $file = __DIR__ . '/resources/TestNamespace.php';

        $result = scan($file);
        $this->assertEquals($result, []);
    }

    public function test2() {
        $file = __DIR__ . '/resources/TestClass.php';

        $result = scan($file);
        $this->assertEquals($result, [['class' => "Bar", 'line' => 3, 'file' => __DIR__ . '/resources/TestClass.php']]);
    }

    public function test3() {
        $file = __DIR__ . '/resources/TestConstructor.php';

        $result = scan($file);
        $this->assertEquals($result, []);
    }
}
