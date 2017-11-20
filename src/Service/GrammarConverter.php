<?php


namespace Service;

use Model\FiniteAutomate;
use Model\Grammar;
use Model\Transition;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class GrammarConverter
{
    public function convert(Grammar $grammar): FiniteAutomate
    {
        $automate = new FiniteAutomate(
            sprintf('FA(%s)', $grammar->getId())
        );

        $nonTermToState = [];
        $states = [];
        $i = 0;
        foreach ($grammar->getNonTerminals() as $nonTerminal) {
            $state = 'q'.$i;
            $nonTermToState[$nonTerminal] = $state;
            $states[] = $state;
            $i++;
        }

        $initialState = $nonTermToState[$grammar->getStartSymbol()];
        $automate->setInitialState($initialState);

        $finalState = 'q'.$i;
        $states[] = $finalState;
        $finalStates = [$finalState];
        if ($grammar->startGoesInEpsilon()) {
            $finalStates[] = $initialState;
        }

        foreach ($grammar->getProductions() as $production) {
            $lhs = $production->getLhs();

            foreach ($production->getRhs() as $group) {
                $groupSize = strlen($group);
                if ($groupSize > 1) {
                    $s1 = $nonTermToState[$lhs];
                    $s2 = $nonTermToState[substr($group, 1)];
                    $automate->addTransition(
                        new Transition($s1, $s2, $group[0])
                    );
                }

                if ($groupSize === 1 && $group !== Grammar::EPSILON) {
                    $s1 = $nonTermToState[$lhs];
                    $s2 = $finalStates[0];
                    $automate->addTransition(
                        new Transition($s1, $s2, $group)
                    );
                }
            }
        }

        $automate->setFinalStates($finalStates);
        return $automate;
    }
}