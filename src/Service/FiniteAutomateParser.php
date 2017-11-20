<?php


namespace Service;

use Model\FiniteAutomate;
use Model\Transition;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class FiniteAutomateParser
{
    /**
     * @param string $input
     *
     * @return FiniteAutomate
     */
    public function parse(string $input): FiniteAutomate
    {
        $lines = Utils::split($input, PHP_EOL);

        if (count($lines) < 3) {
            throw new \InvalidArgumentException(
                sprintf('Invalid finite automate "%s"', $input)
            );
        }

        $finiteAutomate = new FiniteAutomate(array_shift($lines));
        $states = Utils::split(array_shift($lines), Transition::SEPARATOR);
        if ($states < 2) {
            throw new \InvalidArgumentException(
                'Must provide the initial state and at least one final state.'
            );
        }

        $finiteAutomate
            ->setInitialState(array_shift($states))
            ->setFinalStates($states);
        foreach ($lines as $line) {
            $finiteAutomate->addTransition($this->createTransition($line));
        }

        return $finiteAutomate;
    }

    /**
     * @param string $input
     *
     * @return Transition
     */
    private function createTransition(string $input): Transition
    {
        $parts = Utils::split($input, Transition::SEPARATOR);

        if (count($parts) !== 3) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Transition "%s" is invalid. Expected state1,state2,payload',
                    $input
                )
            );
        }

        return new Transition($parts[0], $parts[1], $parts[2]);
    }
}