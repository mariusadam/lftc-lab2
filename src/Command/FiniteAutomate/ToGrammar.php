<?php


namespace Command\FiniteAutomate;

use Service\FiniteAutomateConverter;
use Service\GrammarConverter;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class ToGrammar extends \Command
{
    /**
     * @var FiniteAutomateConverter
     */
    private $converter;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->converter = new FiniteAutomateConverter();
    }

    /**
     * Execute the current command
     */
    public function execute()
    {
        ShowLoaded::create($this->getApplicationState())->execute();

        $id = $this->readline('Enter finite automate id: ');
        $finiteAutomate = $this->getApplicationState()->getFiniteAutomate($id);
        $grammar = $this->converter->convert($finiteAutomate);
        $this->getApplicationState()->addGrammar($grammar);

        $this->writeln(
            sprintf(
                'Created new grammar "%s" from finite automate "%s".',
                $grammar->getId(),
                $finiteAutomate->getId()
            )
        );
    }
}