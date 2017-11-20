<?php

namespace Command\FiniteAutomate;

use Command\Common\BaseRead;
use Command\ReadChoice;
use Service\FiniteAutomateParser;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Read extends \Command
{
    /**
     * @var FiniteAutomateParser
     */
    private $parser;

    /**
     * @var ReadChoice
     */
    private $readCommand;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->parser = new FiniteAutomateParser();
        $this->readCommand = new ReadChoice(
            '',
            'Read finite automate from: '
        );
    }

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->readCommand->execute();
        /** @var BaseRead $last */
        $last = $this->readCommand->getLastExecuted();
        if (null === $last) {
            return;
        }
        $input = $last->getResult();

        $fa = $this->parser->parse($input);
        $this
            ->getApplicationState()
            ->addFiniteAutomate($fa);

        $this->writeln(
            sprintf('Finite automate "%s" was loaded.', $fa->getId())
        );
    }
}