<?php

class Git
{
    public static function update($dotfilesFolder)
    {
        $date = new DateTime();
        $date = $date->format('Ymd-H:i');
        system('cd '.$dotfilesFolder.' && git add . && git commit -m '.$date.' && git push');
    }
}
