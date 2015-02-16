<?php

namespace Command\EmailReminder;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetEmailCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('reminder:set')
            ->setDescription('Ustawia adres e-mail, na który wysyłane są powiadomienia.')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'Adres e-mail'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        // Zapisuje podany e-mail w pliku tekstowym.
        file_put_contents(__DIR__ . '/../../../email.txt', $email);

        $output->writeln(
            'Adres e-mail <info>' . $email . '</info> został zapisany.'
        );
    }
} 