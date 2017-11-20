<?php


namespace Command;

use Command\Common\Read\File;
use Command\Common\Read\Stdin;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class ReadChoice extends Composite
{
    public function __construct($name, $description)
    {
        parent::__construct($name, $description);
        $this->addCommand(new Stdin('s'));
        $this->addCommand(new File('f'));
        $this->setLoopForever(false);
    }
}