<?php

use Illuminate\Support\Str;

const REGX_EMPTY_STRING = '/[\x00-\x1F\x80-\xFF]/';

if (!function_exists('createSlug')) {
    /**
     * Create Slug
     * 
     * @param string $value
     * @param string $separator
     * @param bool $reverse
     * 
     * @return string
     */
    function createSlug(string $value, string $separator = UNDERSCORE, bool $reverse = false): string
    {
        $value = Str::squish($value);
        return $reverse ? Str::ucfirst(Str::replace(UNDERSCORE, NORMAL_SPACE, $value)) : Str::slug($value, $separator);
    }
}

if (!function_exists('removeNonPrintableCharacter')) {
    /**
     * Create Slug
     * 
     * @param string $value
     * 
     * @return mixed
     */
    function removeNonPrintableCharacter(string $value): mixed
    {
        return preg_replace(REGX_EMPTY_STRING, '', $value);
    }
}