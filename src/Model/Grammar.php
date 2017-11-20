<?php


namespace Model;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Grammar
{
    const EPSILON = 'ε';
    const TERMINALS_SEP = ',';

    /**
     * @var string
     */
    private $id;

    /**
     * @var Production[]
     */
    private $productions;

    /**
     * @var string
     */
    private $startSymbol;

    /**
     * @var array
     */
    private $terminals;

    /**
     * Grammar constructor.
     *
     * @param string $id
     * @param array  $terminals
     */
    public function __construct($id, array $terminals)
    {
        $this->id = $id;
        $this->terminals = $terminals;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param Production $production
     */
    public function addProduction(Production $production)
    {
        if (isset($this->productions[$production->getLhs()])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Production for "%s" is already defined: "%s"',
                    $production->getLhs(),
                    $this->productions[$production->getLhs()]->getRhs()
                )
            );
        }

        $this->productions[$production->getLhs()] = $production;
    }

    /**
     * @param string $symbol
     *
     * @return Production
     */
    public function getProduction(string $symbol): Production
    {
        if (!$this->hasProduction($symbol)) {
            throw new \InvalidArgumentException(
                sprintf('There is no production for symbol "%s".', $symbol)
            );
        }

        return $this->productions[$symbol];
    }

    /**
     * @param string $nonTerm
     * @param array  $groupParts
     */
    public function appendProductionGroup(string $nonTerm, array $groupParts)
    {
        if ($this->hasProduction($nonTerm)) {
            $production = $this->getProduction($nonTerm);
        } else {
            $production = new Production($nonTerm, []);
            $this->addProduction($production);
        }

        $production->addRhsValue(implode('', $groupParts));
    }

    /**
     * @param string $symbol
     *
     * @return bool
     */
    public function hasProduction(string $symbol): bool
    {
        return isset($this->productions[$symbol]);
    }

    /**
     * @return string
     */
    public function getStartSymbol(): string
    {
        return $this->startSymbol;
    }

    /**
     * @param string $startSymbol
     *
     * @return Grammar
     */
    public function setStartSymbol(string $startSymbol): Grammar
    {
        $this->startSymbol = $startSymbol;

        return $this;
    }

    /**
     * @param string $symbol
     *
     * @return bool
     */
    public function isNonTerminal(string $symbol): bool
    {
        return isset($this->productions[$symbol]);
    }

    /**
     * @param string $symbol
     *
     * @return bool
     */
    public function isTerminal(string $symbol): bool
    {
        return in_array($symbol, $this->terminals, true)
            || $symbol === self::EPSILON;
    }

    /**
     * @return bool
     */
    public function startGoesInEpsilon(): bool
    {
        return $this
            ->getProduction($this->startSymbol)
            ->contains(self::EPSILON);
    }

    /**
     * Id the grammar is regular it returns an empty array
     *
     * @return array
     */
    public function isRegularErrors(): array
    {
        $errors = [];

        $startGoesInEpsilon = $this->startGoesInEpsilon();

        foreach ($this->productions as $production) {
            $key = (string)$production;
            foreach ($production->getRhs() as $group) {
                $err = $this->validateGroup($group);
                if (!empty($err)) {
                    $errors[$key][] = $err;
                }

                if ($production->getLhs() !== $this->startSymbol && $group === self::EPSILON) {
                    $errors[$key][] = 'Epsilon cannot appear here.';
                }

                if ($startGoesInEpsilon && $group === $this->startSymbol) {
                    $errors[$key][]
                        = 'Start symbol cannot appear on the right hand side.';
                }
            }
        }

        return $errors;
    }

    /**
     * @param string $group
     *
     * @return string
     */
    private function validateGroup(string $group): string
    {
        $groupSize = strlen($group);
        if ($groupSize < 1) {
            return sprintf('Invalid size at %s.', $group);
        }
        if ($groupSize === 1 && !$this->isTerminal($group)) {
            return sprintf('Expected a terminal, got "%s".', $group);
        }
        if ($groupSize > 1
            && !$this->isTerminal($group[0])
            && !$this->isNonTerminal(substr($group, 1))
        ) {
            return sprintf(
                'Expected a terminal and a non-terminal, got "%s"', $group
            );
        }

        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = $this->id.PHP_EOL;
        $output .= implode(self::TERMINALS_SEP, $this->terminals).PHP_EOL;
        $output .= implode(PHP_EOL, $this->productions);

        return $output;
    }

    /**
     * @return array
     */
    public function getTerminals(): array
    {
        return $this->terminals;
    }

    /**
     * @return Production[]
     */
    public function getProductions(): array
    {
        return $this->productions;
    }

    /**
     * @return array
     */
    public function getNonTerminals(): array
    {
        return array_keys($this->productions);
    }
}