<?php

namespace ajf\PHP4_Constructor_Finder;

use PhpParser;

class Scanner extends PhpParser\NodeVisitorAbstract
{
    private $namespaced = FALSE;
    private $hasConstruct = FALSE;
    private $hasSameName = FALSE;
    private $className = "";
    private $file = "";

    public $found = [];

    public function __construct($file)
    {
        $this->file = $file;
    }

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
                    'line' => $node->getLine(),
                    'file' => $this->file
                ];
            }
        }

        if ($node instanceof PhpParser\Node\Namespace_ && !empty($node->getAttribute('stmts')) && $this->namespaced) {
            $this->namespaced = FALSE;
        }
    }
}
