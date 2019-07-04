<?php

class System
{
    public static function mkdir($parameter, $path)
    {
        system('mkdir '.self::_setParameter($parameter).' '.$path);
    }

    public static function copy($parameter, $source, $destination)
    {
        system('cp '.self::_setParameter($parameter).' '.$source.' '.$destination);
    }

    public static function installPackages($executable, $packages)
    {
        system($executable.' '.$packages);
    }

    public static function vcsUpdate($folder, $date)
    {
        system('cd '.$folder.' && git add . && git commit -m '.$date.' && git push');
    }

    private static function _setParameter($parameter)
    {
        if ($parameter) {
            $parameter = '-'.$parameter;
        }

        return $parameter;
    }
}
