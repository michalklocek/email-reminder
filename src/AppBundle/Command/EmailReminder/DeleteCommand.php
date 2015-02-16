<?php

namespace AppBundle\Command\EmailReminder;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('reminder:delete')
            ->setDescription('Usuwa przypomnienie.')
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Wiadomość, która zostanie wysłana na e-mail'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');
        $output->writeln($message);
    }
} 