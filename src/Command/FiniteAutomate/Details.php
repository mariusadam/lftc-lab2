<?php


namespace Command\FiniteAutomate;

use Command\Composite;
use Command\FiniteAutomate\Details\All;
use Command\FiniteAutomate\Details\Alphabet;
use Command\FiniteAutomate\Details\FinalStates;
use Command\FiniteAutomate\Details\InitialState;
use Command\FiniteAutomate\Details\States;
use Command\FiniteAutomate\Details\Transitions;

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

        $id = $this->readline('Enter finite automate id: ');
        $automate = $this->getApplicationState()->getFiniteAutomate($id);

        $details = new Composite('', 'Finite automate details: ');
        $details->addCommand(new States('s', $automate));
        $details->addCommand(new Alphabet('a', $automate));
        $details->addCommand(new InitialState('is', $automate));
        $details->addCommand(new FinalStates('fs', $automate));
        $details->addCommand(new Transitions('t', $automate));
        $details->addCommand(new All('all', $automate));

        $details->execute();
    }
}