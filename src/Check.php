<?php

class Check
{
    public static function isJson($data)
    {
        if (is_array($data)) {
            return true;
        }

        return false;
    }

    public static function isValidArgument($argument)
    {
        if (in_array($argument, ['install', 'update', 'fresh', 'help'])) {
            return true;
        }

        return false;
    }
}
