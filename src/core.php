<?php

namespace ajf\PHP4_Constructor_Finder;

use PhpParser;

require __DIR__ . '/../vendor/autoload.php';

class Scanner extends PhpParser\NodeVisitorAbstract
{
    private $namespaced = FALSE;
    private $hasConstruct = FALSE;
    private $hasSameName = FALSE;
    private $className = "";

    public $found = [];

    public function enterNode(PhpParser\Node $node) {
        if ($node instanceof PhpParser\Node\Stmt\Namespace_) {
            $this->namespaced = TRUE;
        }
        if ($node instanceof PhpParser\Node\Stmt\Class_) {
            $this->hasConstruct = FALSE;
            $this->hasSameName = FALSE;
            $this->className = $node->name; 
        }
        if ($node instanceof PhpParser\Node\Stmt\ClassMethod && !$this->namespaced) {
            if (strcasecmp($node->name, "__construct") === 0) {
                $this->hasConstruct = TRUE;
            } else if (strcasecmp($node->name, $this->className) === 0) {
                $this->hasSameName = TRUE;
            }
        }
    }

    public function leaveNode(PhpParser\Node $node) {
        if ($node instanceof PhpParser\Node\Stmt\Class_) {
            if (!$this->namespaced && $this->hasSameName && !$this->hasConstruct) {
                $this->found[] = [
                    'class' => $this->className,
                    'line' => $node->getLine()
                ];
            }
        }
        if ($node instanceof PhpParser\Node\Namespace_ && !empty($node->getAttribute('stmts')) && $namespaced) {
            $this->namespaced = FALSE;
        }
    }
}

// returns array of arrays like ['class' => 'Foo', 'line' => 27]
function scan($code) {
    $parser = new PhpParser\Parser(new PhpParser\Lexer);
    $stmts = $parser->parse($code);
   
    $scanner = new Scanner;

    $traverser = new PhpParser\NodeTraverser;
    $traverser->addVisitor($scanner);
    $traverser->traverse($stmts);

    return $scanner->found;
}
