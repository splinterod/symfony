<?php


namespace App\Service;


class Slugify
{
    /* permet de gérer le nom pour l'user dans une url */

    public function generate(string $input) : string{

        $input = preg_replace('#[^\\pL\d]+#u', '-', $input);
        // trim
        $input = trim($input, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $input = iconv('utf-8', 'us-ascii//TRANSLIT', $input);
        }

        // lowercase
        $input = strtolower($input);
        // remove unwanted characters
        $input = preg_replace('#[^-\w]+#', '', $input);
        if (empty($input))
        {
            return 'n-a';
        }
        return $input;
    }
}