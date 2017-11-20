<?php


namespace Command\FiniteAutomate;

use Model\FiniteAutomate;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
abstract class FiniteAutomateAware extends \Command
{
    /**
     * @var FiniteAutomate
     */
    private $finiteAutomate;

    /**
     * FiniteAutomateAware constructor.
     *
     * @param string         $name
     * @param FiniteAutomate $finiteAutomate
     */
    public function __construct($name, FiniteAutomate $finiteAutomate)
    {
        parent::__construct($name);
        $this->finiteAutomate = $finiteAutomate;
    }

    /**
     * @return FiniteAutomate
     */
    public function getFiniteAutomate(): FiniteAutomate
    {
        return $this->finiteAutomate;
    }
}