<?php


namespace Command\Common;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
abstract class BaseRead extends \Command
{
    /**
     * @var string
     */
    protected $result;

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }
}