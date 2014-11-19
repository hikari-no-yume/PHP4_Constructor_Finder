<?php

use ajf\PHP4_Constructor_Finder\Scanner;

// returns array of arrays like ['class' => 'Foo', 'line' => 27]
function scan($code) {
    $parser = new PhpParser\Parser(new PhpParser\Lexer);
    $stmts = $parser->parse($code);

    $scanner = new Scanner();
    
    $traverser = new PhpParser\NodeTraverser;
    $traverser->addVisitor($scanner);
    $traverser->traverse($stmts);

    return $scanner->found;
}
