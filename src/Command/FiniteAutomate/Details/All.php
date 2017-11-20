<?php


namespace Command\FiniteAutomate\Details;

use Command\FiniteAutomate\FiniteAutomateAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class All extends FiniteAutomateAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln((string)$this->getFiniteAutomate());
    }
}