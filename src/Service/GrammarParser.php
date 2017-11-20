<?php


namespace Service;

use Model\Grammar;
use Model\Production;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class GrammarParser
{
    /**
     * @param string $input
     *
     * @return Grammar
     */
    public function parse(string $input): Grammar
    {
        $lines = Utils::split($input, PHP_EOL);

        if (count($lines) < 3) {
            throw new \InvalidArgumentException(
                sprintf('Invalid grammar "%s"', $input)
            );
        }

        $id = array_shift($lines);
        $terminals = Utils::split(array_shift($lines), Grammar::TERMINALS_SEP);

        $grammar = new Grammar($id, $terminals);

        $firstProduction = $this->createProduction(array_shift($lines));
        $grammar
            ->setStartSymbol($firstProduction->getLhs())
            ->addProduction($firstProduction);

        foreach ($lines as $line) {
            $grammar->addProduction($this->createProduction($line));
        }

        return $grammar;
    }

    /**
     * @param string $input
     *
     * @return Production
     */
    private function createProduction(string $input)
    {
        $parts = Utils::split($input, Production::ASSIGN);

        if (count($parts) != 2) {
            throw new \InvalidArgumentException(
                sprintf('Invalid production "%s"', $input)
            );
        }

        $rhsParts = Utils::split($parts[1], Production::GROUP_SEPARATOR);

        return new Production($parts[0], $rhsParts);
    }
}