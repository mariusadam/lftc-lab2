<?php

use Model\FiniteAutomate;
use Model\Grammar;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class ApplicationState
{
    /**
     * @var Grammar[]
     */
    private $grammars;

    /**
     * @var FiniteAutomate[]
     */
    private $finiteAutomates;

    public function __construct()
    {
        $this->grammars = [];
        $this->finiteAutomates = [];
    }

    /**
     * @param Grammar $grammar
     */
    public function addGrammar(Grammar $grammar)
    {
        $this->grammars[$grammar->getId()] = $grammar;
    }

    public function addFiniteAutomate(FiniteAutomate $automate)
    {
        $this->finiteAutomates[$automate->getId()] = $automate;
    }

    /**
     * @param string $id
     *
     * @return Grammar
     */
    public function getGrammar(string $id)
    {
        if (!isset($this->grammars[$id])) {
            throw new InvalidArgumentException('Grammar '.$id.' is undefined.');
        }

        return $this->grammars[$id];
    }

    /**
     * @param string $id
     *
     * @return FiniteAutomate
     */
    public function getFiniteAutomate(string $id)
    {
        if (!isset($this->finiteAutomates[$id])) {
            throw new InvalidArgumentException(
                'Finite automate '.$id.' is undefined.'
            );
        }

        return $this->finiteAutomates[$id];
    }

    /**
     * @return Grammar[]
     */
    public function getGrammars(): array
    {
        return $this->grammars;
    }

    /**
     * @return FiniteAutomate[]
     */
    public function getFiniteAutomates(): array
    {
        return $this->finiteAutomates;
    }
}