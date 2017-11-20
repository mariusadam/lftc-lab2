<?php


namespace Command\Grammar\Details;

use Command\Grammar\GrammarAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class StartSymbol extends GrammarAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'Start symbol of grammar "%s" is "%s"',
                $this->getGrammar()->getId(),
                $this->getGrammar()->getStartSymbol()
            )
        );
    }
}