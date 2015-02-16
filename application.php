<?php

require __DIR__.'/vendor/autoload.php';

use Command\EmailReminder;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Application;

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

// database configuration parameters
$connectionParams = array(
    'dbname' => 'email_reminder',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
    'charset' => 'utf8'
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465)
    ->setUsername('login')
    ->setPassword('password')
;
// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

$loader = new \Twig_Loader_Filesystem(__DIR__ . '/src/Resources/views');
$twig = new \Twig_Environment($loader);

$application = new Application();
$application->add(new EmailReminder\AddCommand($entityManager));
$application->add(new EmailReminder\ListCommand($entityManager));
$application->add(new EmailReminder\DeleteCommand($entityManager));
$application->add(new EmailReminder\SetEmailCommand());
$application->add(new EmailReminder\SendCommand($entityManager, $mailer, $twig));
$application->run();