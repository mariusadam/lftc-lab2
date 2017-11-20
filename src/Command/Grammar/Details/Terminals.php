<?php


namespace Command\Grammar\Details;

use Command\Grammar\GrammarAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Terminals extends GrammarAware
{
    /**
     * Execute the current command
     */
    public function execute()
    {
        $grammar = $this->getGrammar();
        $this->writeln(
            sprintf(
                'Terminals of %s are (%s)',
                $grammar->getId(),
                implode(', ', $grammar->getTerminals())
            )
        );
    }
}