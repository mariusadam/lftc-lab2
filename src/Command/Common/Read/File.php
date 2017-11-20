<?php


namespace Command\Common\Read;

use Command\Common\BaseRead;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class File extends BaseRead
{
    /**
     * Execute the current command
     */
    public function execute()
    {
        $file = $this->readline("Enter file name: ");
        if (!file_exists($file) && is_file($file)) {
            throw new \RuntimeException('Invalid file path '.$file);
        }

        $this->result = file_get_contents($file);
    }
}