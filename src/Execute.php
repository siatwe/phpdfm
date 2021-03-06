<?php

class Execute
{
    public static function run($method, $dotfilesFolder, $data, $installExecutable)
    {
        switch ($method) {
            case 'install':
                self::install($dotfilesFolder, $data, '', $installRequirements = false);
                break;
            case 'update':
                self::update($dotfilesFolder, $data);
                break;
            case 'fresh':
                self::install($dotfilesFolder, $data, $installExecutable, $installRequirements = true);
                break;
            case 'help':
                Message::help();
                break;
            default:
                break;
        }
    }

    private static function update($dotfilesFolder, $data)
    {
        foreach ($data as  $appName => $managedApp) {
            System::mkdir('p', $dotfilesFolder.'/'.$appName);

            foreach ($managedApp as $type => $destination) {
                if ('requirements' === $type) {
                    continue;
                }
                if ('files' === $type) {
                    self::updateFile($destination, $dotfilesFolder, $appName);
                }
                if ('dirs' === $type) {
                    self::updateDir($destination, $dotfilesFolder, $appName);
                }
            }
        }
        Git::update($dotfilesFolder);
    }

    private static function install($dotfilesFolder, $data, $installExecutable, $isFresh)
    {
        foreach ($data as  $appName => $managedApp) {
            foreach ($managedApp as $type => $destination) {
                if ('requirements' === $type) {
                    if ($isFresh) {
                        self::installRequirements($appName, $destination, $installExecutable);
                    }
                }
                if ('files' === $type) {
                    self::installFile($destination, $dotfilesFolder, $appName);
                }
                if ('dirs' === $type) {
                    self::installDir($destination, $dotfilesFolder, $appName);
                }
            }
        }
    }

    private static function updateFile($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $path) {
            $configFileName = self::getConfigFileName($path);

            if (!Check::isIdentical($path, $dotfilesFolder.'/'.$appName.'/'.$configFileName, false)) {
                System::copy(null, $path, $dotfilesFolder.'/'.$appName.'/');
                Message::status($appName, 'file', 'updated');
            } else {
                Message::status($appName, 'file', 'identical');
            }
        }
    }

    private static function updateDir($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $dir) {
            $dirName = str_replace('/', '', strrchr($dir, '/'));

            System::copy('r', $dir, $dotfilesFolder.'/'.$appName.'/');

            Message::status($appName, 'directory', 'updated');
        }
    }

    private static function installFile($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $path) {
            $configFileName = self::getConfigFileName($path);

            System::copy(null, $dotfilesFolder.'/'.$appName.'/'.$configFileName, $path);

            Message::status($appName, 'file', 'installed');
        }
    }

    private static function installDir($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $dir) {
            $dirName = str_replace('/', '', strrchr($dir, '/'));

            $dirDestination = preg_replace('/'.$dirName.'/', '', $dir);

            System::copy('r', $dotfilesFolder.'/'.$appName.'/'.$dirName, $dirDestination);

            Message::status($appName, 'directory', 'installed');
        }
    }

    private static function installRequirements($appName, $requirements, $installExecutable)
    {
        $installationCandidates = '';
        foreach ($requirements as $requirement) {
            $installationCandidates .= $requirement.' ';
        }
        if (!empty($installationCandidates)) {
            Message::infoInstallationCandidates($appName, $installationCandidates);

            System::installPackages($installExecutable, $installationCandidates);
        }
    }

    private static function getConfigFileName($path)
    {
        return str_replace('/', '', strrchr($path, '/'));
    }
}
