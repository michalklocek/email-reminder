<?php

require __DIR__.'/vendor/autoload.php';

use AppBundle\Command\EmailReminder;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Application;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'path' => __DIR__ . '/app/config/config.yml',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$application = new Application();
$application->add(new EmailReminder\AddCommand($entityManager));
$application->add(new EmailReminder\ListCommand($entityManager));
//$application->add(new EmailReminder\DeleteCommand());
//$application->add(new EmailReminder\SetEmailCommand());
$application->run();