<?php

class Create
{
    public static function arrayFromJson($file)
    {
        $jsonData = json_decode(file_get_contents($file), true);

        return $jsonData;
    }
}
