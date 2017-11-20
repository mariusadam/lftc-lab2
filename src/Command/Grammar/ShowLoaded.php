<?php


namespace Command\Grammar;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class ShowLoaded extends \Command
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        $grammars = $this->getApplicationState()->getGrammars();
        if (empty($grammars)) {
            $this->writeln('There are no loaded grammars');

            return;
        }

        $this->writeln('Available grammars are: ');
        foreach ($grammars as $grammar) {
            $this->writeln('    '.$grammar->getId());
        }
    }
}