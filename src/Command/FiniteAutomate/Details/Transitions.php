<?php


namespace Command\FiniteAutomate\Details;

use Command\FiniteAutomate\FiniteAutomateAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Transitions extends FiniteAutomateAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'The transitions of finite automate "%s" are: ',
                $this->getFiniteAutomate()->getId()
            )
        );
        foreach ($this->getFiniteAutomate()->getTransitions() as $transition) {
            $this->writeln('        '.$transition->prettyPrint());
        }
    }
}