<?php


namespace Model;

use Service\Utils;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Transition
{
    const SEPARATOR = ',';
    const PAYLOAD_SEPARATOR = '|';

    /**
     * @var string
     */
    private $stateOne;

    /**
     * @var string
     */
    private $stateTwo;

    /**
     * @var  array
     */
    private $payload;

    /**
     * Transition constructor.
     *
     * @param string $stateOne
     * @param string $stateTwo
     * @param string $value
     */
    public function __construct($stateOne, $stateTwo, $value)
    {
        $this->stateOne = $stateOne;
        $this->stateTwo = $stateTwo;

        $values = Utils::split($value, self::PAYLOAD_SEPARATOR);
        $this->payload = $values;
    }

    /**
     * @return string
     */
    public function getStateOne(): string
    {
        return $this->stateOne;
    }

    /**
     * @return string
     */
    public function getStateTwo(): string
    {
        return $this->stateTwo;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param string $val
     */
    public function addValue(string $val)
    {
        if (in_array($val, $this->payload, true)) {
            return;
        }

        $this->payload[] = $val;
    }

    /**
     * @return string
     */
    public function getPayloadFormatted(): string
    {
        return implode(self::PAYLOAD_SEPARATOR, $this->payload);
    }

    /**
     * @return string
     */
    public function prettyPrint(): string
    {
        return sprintf(
            '%s--(%s)-->%s',
            $this->getStateOne(),
            $this->getPayloadFormatted(),
            $this->getStateTwo()
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(
            self::SEPARATOR,
            [$this->stateOne, $this->stateTwo, $this->getPayloadFormatted()]
        );
    }
}