<?php


namespace Command\FiniteAutomate;

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
        $automates = $this->getApplicationState()->getFiniteAutomates();
        if (empty($automates)) {
            $this->writeln('There are no loaded finite automates');

            return;
        }

        $this->writeln('Available finite automates are: ');
        foreach ($automates as $automate) {
            $this->writeln('    '.$automate->getId());
        }
    }
}