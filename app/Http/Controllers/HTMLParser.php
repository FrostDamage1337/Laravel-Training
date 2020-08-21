<?php

namespace App\Http\Controllers;

class HTMLParser extends Controller
{
    public static function parse($url)
    {
        return file_get_contents($url);
    }
}
