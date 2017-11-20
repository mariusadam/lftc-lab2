<?php

namespace Command\Grammar;

use Command\Common\BaseRead;
use Command\ReadChoice;
use Service\GrammarParser;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Read extends \Command
{
    /**
     * @var GrammarParser
     */
    private $parser;

    /**
     * @var ReadChoice
     */
    private $readCommand;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->parser = new GrammarParser();
        $this->readCommand = new ReadChoice(
            '',
            'Read grammar from: '
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

        $grammar = $this->parser->parse($input);
        $this
            ->getApplicationState()
            ->addGrammar($grammar);

        $this->writeln(
            sprintf('Grammar "%s" was loaded.', $grammar->getId())
        );
    }
}