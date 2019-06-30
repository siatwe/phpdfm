<?php
class Execute
{
    public static function run($method, $dotfilesFolder, $data, $installExecutable)
    {
        switch ($method) {
        case 'install': self::install($dotfilesFolder, $data, '', $installRequirements = false); break;
        case 'update': self::update($dotfilesFolder, $data); break;
        case 'fresh': self::install($dotfilesFolder, $data, $installExecutable, $installRequirements = true); break;
        case 'help': Message::help(); break;
        default: break;
        }
    }
    private static function update($dotfilesFolder, $data)
    {
        foreach ($data as  $appName => $managedApp) {
            system('mkdir -p '.$dotfilesFolder.'/'.$appName);
            foreach ($managedApp as $type => $destination) {
                if ($type === 'requirements') {
                    continue;
                }
                if ($type === 'files') {
                    self::updateFile($destination, $dotfilesFolder, $appName);
                }
                if ($type === 'dirs') {
                    self::updateDir($destination, $dotfilesFolder, $appName);
                }
            }
        }
        self::gitUpdate($dotfilesFolder);
    }
    private static function install($dotfilesFolder, $data, $installExecutable, $isFresh)
    {
        foreach ($data as  $appName => $managedApp) {
            foreach ($managedApp as $type => $destination) {
                if ($type === 'requirements') {
                    if ($isFresh) {
                        self::installRequirements($appName, $destination, $installExecutable);
                    }
                }
                if ($type === 'files') {
                    self::installFile($destination, $dotfilesFolder, $appName);
                }
                if ($type === 'dirs') {
                    self::installDir($destination, $dotfilesFolder, $appName);
                }
            }
        }
    }
    private static function updateFile($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $path) {
            $configFileName = self::getConfigFileName($path);
            system('cp '.$path.' '.$dotfilesFolder.'/'.$appName.'/');
            Message::status($appName, 'file', 'updated');
        }
    }
    private static function updateDir($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $dir) {
            $dirName = str_replace('/', '', strrchr($dir, '/'));
            system('cp -r '.$dir.' '.$dotfilesFolder.'/'.$appName.'/');
            Message::status($appName, 'directory', 'updated');
        }
    }
    private static function installFile($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $path) {
            $configFileName = self::getConfigFileName($path);
            system(
                'cp '.$dotfilesFolder.'/'.$appName.'/'.$configFileName.' '.$path
            );
            Message::status($appName, 'file', 'installed');
        }
    }
    private static function installDir($destination, $dotfilesFolder, $appName)
    {
        foreach ($destination as $dir) {
            $dirName = str_replace('/', '', strrchr($dir, '/'));
            $dirDestination = preg_replace('/'.$dirName.'/', '', $dir);
            system(
                'cp -r '.$dotfilesFolder.'/'.$appName.'/'.$dirName.' '.$dirDestination
            );
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
            system($installExecutable.' '.$installationCandidates);
        }
    }
    private static function getConfigFileName($path)
    {
        return str_replace('/', '', strrchr($path, '/'));
    }
    private static function gitUpdate($dotfilesFolder)
    {
        $date = new DateTime();
        $date = $date->format('Ymd-H:i');
        system('cd '.$dotfilesFolder.' && git add . && git commit -m '.$date.' && git push');
    }
}
