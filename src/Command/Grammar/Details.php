<?php


namespace Command\Grammar;

use Command\Composite;
use Command\Grammar\Details\All;
use Command\Grammar\Details\NonTerminals;
use Command\Grammar\Details\Productions;
use Command\Grammar\Details\StartSymbol;
use Command\Grammar\Details\Terminals;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Details extends \Command
{
    /**
     * Execute the current command
     */
    public function execute()
    {
        ShowLoaded::create($this->getApplicationState())->execute();

        $id = $this->readline('Enter grammar id: ');
        $grammar = $this->getApplicationState()->getGrammar($id);

        $detailsCmd = new Composite('', 'Grammar details');
        $detailsCmd->addCommand(new Terminals('t', $grammar));
        $detailsCmd->addCommand(new NonTerminals('nt', $grammar));
        $detailsCmd->addCommand(new StartSymbol('sts', $grammar));
        $detailsCmd->addCommand(new Productions('p', $grammar));
        $detailsCmd->addCommand(new All('a', $grammar));

        $detailsCmd->execute();
    }
}