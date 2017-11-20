<?php


namespace Command\Grammar\Details;

use Command\Grammar\GrammarAware;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class All extends GrammarAware
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->writeln((string)$this->getGrammar());
    }
}