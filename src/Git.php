<?php

class Git
{
    public static function update($dotfilesFolder)
    {
        $date = new DateTime();
        $date = $date->format('Ymd-H:i');

        System::vcsUpdate($dotfilesFolder, $date);
    }
}
