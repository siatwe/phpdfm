<?php

include 'Style.php';
class Message
{
    public static function invalidJson($wannaBeJson)
    {
        echo Style::font('bold', 'aadm: ').Style::color('red', 'Given JSON ('.$wannaBeJson.') is invalid or corrupted!')."\nSee help for details.\n";
        exit;
    }

    public function invalidArgument($wannaBeArgument)
    {
        echo Style::font('bold', 'aadm: ').Style::color('red', 'Given  Argument ('.$wannaBeArgument.') is invalid!')."\nSee help for details.\n";
        exit;
    }

    public function help()
    {
        echo
            "usage: aadm [options] (default without options: update)
    where options are:
    install\t copy all files found in dotfiles .json to its given path
    update\t copy all files found in dotfiles .json to the dotfiles repository, each application in own folder
    fresh\t like 'install' but also tries to install all given requirements with the install executable given in config.ini
    help\t show this help message";
        exit;
    }

    public static function status($appName, $type, $method)
    {
        echo Style::font('bold', 'aadm: ').Style::color('blue', $appName).' ['.Style::color('file' == $type ? 'yellow' : 'magenta', $type).']: '.Style::color('green', $method)."\n";
    }

    public static function infoInstallationCandidates($appName, $installationCanditates)
    {
        echo Style::font('bold', 'aadm: ').'Try to install the following requirements for '.Style::color('blue', $appName)."...\n";
        echo Style::font('bold', 'aadm: ').$installationCanditates."\n";
    }
}
