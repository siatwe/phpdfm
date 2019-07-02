#! /bin/php
<?php
$config = parse_ini_file('config.ini', true);

include $config['locations']['aadm'].'/src/Check.php';
include $config['locations']['aadm'].'/src/Create.php';
include $config['locations']['aadm'].'/src/Message.php';
include $config['locations']['aadm'].'/src/Execute.php';

$dotfileRepositoryDestination = $config['locations']['dotfilesDir'];
$configFileDestination = $dotfileRepositoryDestination.'/'.$config['locations']['json'];

$data = Create::arrayFromJson($configFileDestination);

if (!Check::isJson($data)) {
    Message::invalidJson($data);
}

if (!empty($argv[1])) {
    if (Check::isValidArgument($argv[1])) {
        Execute::run(
            $argv[1],
            $dotfileRepositoryDestination,
            $data,
            $config['executables']['installation']
        );
    } else {
        Message::invalidArgument($argv[1]);
    }
} else {
    Execute::run(
        'update',
        $dotfileRepositoryDestination,
        $data,
        $config['executables']['installation']
    );
    exit;
}
