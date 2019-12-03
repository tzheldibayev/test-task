<?php

namespace App\Helpers;

/**
 * Class Slugger
 * @package App\Helpers
 */
class Slugger
{
    private const HOSTNAME = '';
    private const ALPHA_MAP = [
        "а" => "a",
        "ый" => "iy",
        "ые" => "ie",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "yo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "y",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "kh",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "shch",
        "ь" => "",
        "ы" => "y",
        "ъ" => "",
        "э" => "e",
        "ю" => "yu",
        "я" => "ya",
        "йо" => "yo",
        "ї" => "yi",
        "і" => "i",
        "є" => "ye",
        "ґ" => "g"
    ];

    /**
     * @param $id
     * @param $name
     * @return string
     */
    public static function generate($id, $name)
    {
        $convertedAlpha = self::convertAlpha(mb_strtolower($name));
        $convertedSymbols = self::convertSymbols($convertedAlpha);
        $removedDashes = self::removeDuplicateDashes($convertedSymbols);
        $trimmedDashes = self::trimDashes($removedDashes);
        return sprintf('%s%d-%s', self::HOSTNAME, $id, $trimmedDashes);
    }

    /**
     * @param $text
     * @return string
     */
    private static function convertAlpha($text)
    {
        return strtr($text, self::ALPHA_MAP);
    }

    /**
     * @param $text
     * @return string|string[]|null
     */
    private static function convertSymbols($text)
    {
        return preg_replace('/[^A-Za-z0-9]/', '-', $text);
    }

    /**
     * @param $text
     * @return string|string[]|null
     */
    private static function removeDuplicateDashes($text)
    {
        return preg_replace('/-+/', '-', $text);
    }

    /**
     * @param $text
     * @return string
     */
    private static function trimDashes($text)
    {
        return trim($text, '-');
    }
}