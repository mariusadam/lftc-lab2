<?php


namespace Service;

use Model\FiniteAutomate;
use Model\Grammar;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class FiniteAutomateConverter
{
    const START_SYM = 'S';

    private $labels;

    public function __construct()
    {
        $this->labels = range('A', 'Z');
    }

    /**
     * @param int $offset
     *
     * @return string
     */
    private function getLabel(int $offset)
    {
        return 'X'.$offset;
//        if (!isset($this->labels[$offset])) {
//            $off = $offset % count($this->labels);
//
//            return $this->labels[$off].$offset;
//        }
//
//        return $this->labels[$offset];
    }

    public function convert(FiniteAutomate $automate): Grammar
    {
        $id = sprintf('GR(%s)', $automate->getId());
        $grammar = new Grammar($id, $automate->getAlphabet());
        $grammar->setStartSymbol(self::START_SYM);

        $states = $automate->getStates();
        $stateToNonTerm = [
            $automate->getInitialState() => self::START_SYM,
        ];
        $i = 1;
        foreach ($states as $state) {
            if (!$automate->isInitial($state)) {
                $stateToNonTerm[$state] = $this->getLabel($i);
                $i++;
            }
        }

        $initialFinalAndIncoming = false;
        if ($automate->isInitialFinal()) {
            $incoming = false;
            foreach ($automate->getTransitions() as $trans) {
                if ($automate->isInitial($trans->getStateTwo())) {
                    $incoming = true;
                    break;
                }
            }

            if ($incoming) {
//                $stateToNonTerm[$automate->getInitialState()] = 'A0';
                $initialFinalAndIncoming = true;
            }

            $grammar->appendProductionGroup(
                self::START_SYM, [Grammar::EPSILON]
            );
        }

        foreach ($automate->getTransitions() as $trans) {
            if ($automate->isFinal($trans->getStateTwo())) {
                $nonTerm = $stateToNonTerm[$trans->getStateOne()];

                $grammar->appendProductionGroup($nonTerm, $trans->getPayload());

                if ($automate->isInitial($trans->getStateOne())
                    && $initialFinalAndIncoming
                ) {
                    $grammar->appendProductionGroup(
                        self::START_SYM, $trans->getPayload()
                    );
                }
            }

            $nonTerm1 = $stateToNonTerm[$trans->getStateOne()];
            $nonTerm2 = $stateToNonTerm[$trans->getStateTwo()];

            $values = $trans->getPayload();
            $values[] = $nonTerm2;
            $grammar->appendProductionGroup($nonTerm1, $values);

            if ($automate->isInitial($trans->getStateOne())
                && $initialFinalAndIncoming
            ) {
                $grammar->appendProductionGroup(self::START_SYM, $values);
            }
        }

        return $grammar;
    }
}