<?php


namespace Command\Grammar;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class IsRegular extends \Command
{

    /**
     * Execute the current command
     */
    public function execute()
    {
        ShowLoaded::create($this->getApplicationState())->execute();

        $id = $this->readline('Enter grammar id: ');
        $grammar = $this->getApplicationState()->getGrammar($id);
        $errors = $grammar->isRegularErrors();
        $isPart = 'is';
        if (!empty($errors)) {
            $isPart = 'is not';
        }
        $this->writeln(
            sprintf('Grammar "%s" %s regular', $grammar->getId(), $isPart)
        );
        foreach ($errors as $key => $error) {
            $this->writeln($key);
            foreach ($error as $item) {
                $this->writeln('        '.$item);
            }
        }
    }
}