<?php


namespace Command\FiniteAutomate\Details;

use Command\FiniteAutomate\FiniteAutomateAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class InitialState extends FiniteAutomateAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'The final state of finite automate "%s" is "%s"',
                $this->getFiniteAutomate()->getId(),
                $this->getFiniteAutomate()->getInitialState()
            )
        );
    }
}