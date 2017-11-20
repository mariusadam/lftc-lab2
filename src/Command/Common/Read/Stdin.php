<?php


namespace Command\Common\Read;

use Command\Common\BaseRead;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Stdin extends BaseRead
{
    /**
     * @const
     */
    const END_CHAR = '!';

    /**
     * Execute the current command
     */
    public function execute()
    {
        $this->result = '';
        while (true) {
            $c = fgetc(STDIN);

            if ($c === self::END_CHAR) {
                break;
            }

            $this->result .= $c;
        }

        $this->result = trim($this->result);
    }
}