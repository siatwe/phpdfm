<?php

class Read
{
    public static function config($path)
    {
        return parse_ini_file($path);
    }

    public static function json($path)
    {
        return json_decode($path, true);
    }
}
