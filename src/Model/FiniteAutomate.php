<?php


namespace Model;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class FiniteAutomate
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $initialState;

    /**
     * @var array
     */
    private $finalStates;

    /**
     * @var Transition[];
     */
    private $transitions;

    /**
     * @var array
     */
    private $alphabet;

    /**
     * @var array
     */
    private $states;

    /**
     * FiniteAutomate constructor.
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->transitions = [];
        $this->states = [];
        $this->alphabet = [];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getInitialState(): string
    {
        return $this->initialState;
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    public function isInitial(string $state) : bool
    {
        return $this->getInitialState() === $state;
    }

    /**
     * @param string $initialState
     *
     * @return FiniteAutomate
     */
    public function setInitialState(string $initialState): FiniteAutomate
    {
        $this->initialState = $initialState;

        return $this;
    }

    /**
     * @param array $finalStates
     *
     * @return FiniteAutomate
     */
    public function setFinalStates(array $finalStates): FiniteAutomate
    {
        $this->finalStates = $finalStates;

        return $this;
    }

    /**
     * @return Transition[]
     */
    public function getTransitions(): array
    {
        return $this->transitions;
    }

    /**
     * @return array
     */
    public function getFinalStates(): array
    {
        return $this->finalStates;
    }

    /**
     * @return array
     */
    public function getAlphabet(): array
    {
        return array_keys($this->alphabet);
    }


    /**
     * @return array
     */
    public function getStates(): array
    {
        return array_keys($this->states);
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    public function isFinal(string $state): bool
    {
        return in_array($state, $this->finalStates, true);
    }

    /**
     * @return bool
     */
    public function isInitialFinal(): bool
    {
        return $this->isFinal($this->getInitialState());
    }

    /**
     * @param Transition $transition
     */
    public function addTransition(Transition $transition)
    {
        $key = $transition->getStateOne().' -> '.$transition->getStateTwo();
        if (isset($this->transitions[$key])) {
            $t = $this->transitions[$key];
            foreach ($transition->getPayload() as $value) {
                $t->addValue($value);
            }
        }

        $this->transitions[$key] = $transition;

        $this->states[$transition->getStateOne()] = true;
        $this->states[$transition->getStateTwo()] = true;
        foreach ($transition->getPayload() as $item) {
            $this->alphabet[$item] = true;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = $this->getId().PHP_EOL;
        $states = $this->getFinalStates();
        array_unshift($states, $this->getInitialState());
        $output .= implode(Transition::SEPARATOR, $states).PHP_EOL;
        $output .= implode(PHP_EOL, $this->transitions);

        return $output;
    }
}