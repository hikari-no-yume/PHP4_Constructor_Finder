<?php

class Tests extends PHPUnit_Framework_TestCase
{
    public function test1() {
        $file = <<<PHP
<?php

namespace Foo {
    class Bar {
        public function bar() {
        }
    }
}
namespace Bar {
    class Bar {
        public function bar() {
        }
    }
}
PHP;

        $result = scan($file);
        $this->assertEquals($result, []);
    }

    public function test2() {
        $file = <<<PHP
<?php

class Bar {
    public function bar() {
    }
}
PHP;

        $result = scan($file);
        $this->assertEquals($result, [['class' => "Bar", 'line' => 3]]);
    }

    public function test3() {
        $file = <<<PHP
<?php

class Bar {
    public function bar() {
    }
    public function __construct() {
    }
}
PHP;

        $result = scan($file);
        $this->assertEquals($result, []);
    }
}
