<?php


namespace Command\Grammar;

use Model\Grammar;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
abstract class GrammarAware extends \Command
{
    /**
     * @var Grammar
     */
    private $grammar;

    public function __construct($name, Grammar $grammar)
    {
        parent::__construct($name);
        $this->grammar = $grammar;
    }

    /**
     * @return Grammar
     */
    public function getGrammar(): Grammar
    {
        return $this->grammar;
    }
}