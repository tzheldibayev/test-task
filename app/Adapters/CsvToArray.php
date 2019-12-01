<?php

namespace App\Adapters;

/**
 * Class CsvToArray
 * @package App\Adapters
 */
class CsvToArray
{
    /**
     * @param  string  $filename
     * @param  string  $delimiter
     * @return array
     */
    public static function handle($filename = '', $delimiter = ';'): array
    {
        $header = null;
        $result = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $result[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $result;
    }
}