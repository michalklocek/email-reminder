<?php

namespace Command\EmailReminder;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('reminder:list')
            ->setDescription('Wyświetla listę przypomnień.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reminders = $this->em->getRepository('Reminder')->findAll();

        // Wyświetla każde powiadomienie w nowej linii.
        foreach ($reminders as $reminder) {
            $output->writeln(
                '(' . $reminder->getId() . ') '
                . '<info>' . $reminder->getMessage() . '</info> do wysłania w dniu '
                . '<info>' . $reminder->getSendAt()->format('d.m.Y H:i') . '</info>'
            );
        }
    }
}