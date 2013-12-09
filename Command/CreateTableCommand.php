<?php

namespace TwoDudes\ErrorLoggerBundle\Command;

use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TranslationCommand
 * @package Mayzus\IndexBundle\Command
 */
class CreateTableCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('twodudes:errorlogger:setup')->setDescription('Create a table for errors');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = $this->getContainer()->getParameter('two_dudes.storage_service_params');

        try {
            $connString = 'mysql:host=' . $params['db_host'] . ';port=' . $params['db_port'] . ';dbname=' . $params['db_name'];
            $pdo = new PDO($connString, $params['db_user'], $params['db_password']);
        } catch (\PDOException $ex) {
            $output->getFormatter()->setStyle('error', new OutputFormatterStyle('white', 'red'));
            $output->writeln("\n<error>\n Could not connect to the database [{$ex->getMessage()}] \n</error>\n");
            return;
        }

        $pdo->query("
            CREATE TABLE `errors` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `message` text,
              `trace` text,
              `created_at` datetime DEFAULT NULL,
              `file` varchar(255) DEFAULT NULL,
              `line` int(10) DEFAULT NULL,
              `type` varchar(255) DEFAULT NULL,
              `count` int(11) DEFAULT '0',
              `hash` varchar(255) DEFAULT NULL,
              `server` text,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $output->getFormatter()->setStyle('success', new OutputFormatterStyle('green'));
        $output->writeln("\n<success>Table successfully created</success>\n");
    }
}