<?php


namespace Service;

/**
 * @author Marius Adam <marius.adam134@gmail.com>
 */
class Utils
{
    /**
     * @param string $input
     * @param string $delimiter
     *
     * @return array
     */
    public static function split(string $input, string $delimiter): array
    {
        $parts = explode($delimiter, $input);
        $parts = array_map('trim', $parts);

        return array_filter($parts);
    }
}