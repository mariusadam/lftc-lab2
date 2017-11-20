<?php


namespace Command\Grammar;

use Service\FiniteAutomateConverter;
use Service\GrammarConverter;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class ToFiniteAutomate extends \Command
{
    /**
     * @var GrammarConverter
     */
    private $converter;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->converter = new GrammarConverter();
    }

    /**
     * Execute the current command
     */
    public function execute()
    {
        ShowLoaded::create($this->getApplicationState())->execute();

        $id = $this->readline('Enter grammar id: ');
        $grammar = $this->getApplicationState()->getGrammar($id);
        $finiteAutomate = $this->converter->convert($grammar);
        $this->getApplicationState()->addFiniteAutomate($finiteAutomate);

        $this->writeln(
            sprintf(
                'Created new finite automate "%s" from grammar "%s"',
                $finiteAutomate->getId(),
                $grammar->getId()
            )
        );
    }
}