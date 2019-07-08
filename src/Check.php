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

    public static function isIdentical($dataA, $dataB, $dir)
    {
        $dataA = str_replace('~', $_SERVER['HOME'], $dataA);
        $dataB = str_replace('~', $_SERVER['HOME'], $dataB);

        if ($dir) {
            // TODO: Check if dirs are identical
        } else {
            return self::areFilesIdentical($dataA, $dataB);
        }

        return false;
    }

    private static function areFilesIdentical($fileA, $fileB)
    {
        if (filesize($fileA) === filesize($fileB) && md5_file($fileA) === md5_file($fileB)) {
            return true;
        }
    }

    // TODO: Test function
    private static function getDirectorySize($path)
    {
        $bytestotal = 0;
        $path = realpath($path);
        if (false !== $path && '' != $path && file_exists($path)) {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
                $bytestotal += $object->getSize();
            }
        }

        return $bytestotal;
    }
}
