<?php

use ajf\PHP4_Constructor_Finder\Scanner;

// returns array of arrays like ['class' => 'Foo', 'line' => 27]
function scan($file) {
    $code = file_get_contents($file);
    $parser = new PhpParser\Parser(new PhpParser\Lexer);
    $stmts = $parser->parse($code);

    $scanner = new Scanner($file);

    $traverser = new PhpParser\NodeTraverser;
    $traverser->addVisitor($scanner);
    $traverser->traverse($stmts);

    return $scanner->found;
}
