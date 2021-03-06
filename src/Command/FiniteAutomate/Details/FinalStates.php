<?php


namespace Command\FiniteAutomate\Details;

use Command\FiniteAutomate\FiniteAutomateAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class FinalStates extends FiniteAutomateAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'The final states of finite automate "%s" are (%s)',
                $this->getFiniteAutomate()->getId(),
                implode(', ', $this->getFiniteAutomate()->getFinalStates())
            )
        );
    }
}