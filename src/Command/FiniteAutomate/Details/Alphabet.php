<?php


namespace Command\FiniteAutomate\Details;

use Command\FiniteAutomate\FiniteAutomateAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Alphabet extends FiniteAutomateAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'The alphabet of finite automate "%s" is (%s)',
                $this->getFiniteAutomate()->getId(),
                implode(', ', $this->getFiniteAutomate()->getAlphabet())
            )
        );
    }
}