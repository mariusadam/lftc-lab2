<?php


namespace Command\Grammar\Details;

use Command\Grammar\GrammarAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Productions extends GrammarAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln(
            sprintf(
                'Productions of grammar "%s" are: %s%s',
                $this->getGrammar()->getId(),
                PHP_EOL,
                implode(PHP_EOL, $this->getGrammar()->getProductions())
            )
        );
    }
}