<?php


namespace Command\Grammar\Details;

use Command\Grammar\GrammarAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class NonTerminals extends GrammarAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'Non terminals of grammar "%s" are (%s)',
                $this->getGrammar()->getId(),
                implode(', ', $this->getGrammar()->getNonTerminals())
            )
        );
    }
}