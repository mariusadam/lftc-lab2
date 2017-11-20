<?php


namespace Model;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Production
{
    const ASSIGN = '->';
    const GROUP_SEPARATOR = '|';

    /**
     * @var string
     */
    private $lhs;

    /**
     * @var array
     */
    private $rhs;

    /**
     * Production constructor.
     *
     * @param string $lhs
     * @param array  $rhs
     */
    public function __construct($lhs, array $rhs)
    {
        $this->lhs = $lhs;
        $this->rhs = $rhs;
    }

    /**
     * @return string
     */
    public function getLhs(): string
    {
        return $this->lhs;
    }

    /**
     * @return array
     */
    public function getRhs(): array
    {
        return $this->rhs;
    }

    /**
     * @param string $val
     */
    public function addRhsValue(string $val)
    {
        if ($this->contains($val)) {
            return;
        }

        $this->rhs[] = $val;
    }

    /**
     * @param string $symbol
     *
     * @return bool
     */
    public function contains(string $symbol): bool
    {
        return in_array($symbol, $this->rhs, true);
    }

//    /**
//     * @param array $values
//     */
//    public function addRhsValues(array $values)
//    {
//        echo $this->getLhs() . ' ++ ' . implode(', ', $values).PHP_EOL;
//        foreach ($values as $value) {
//            $this->addRhsValue($value);
//        }
//    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s %s %s',
            $this->getLhs(),
            self::ASSIGN,
            implode(self::GROUP_SEPARATOR, $this->getRhs())
        );
    }
}