<?php

namespace AppBundle\Command\EmailReminder;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends ContainerAwareCommand
{
    protected $em;

    public function __construct(ObjectManager $em = null)
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
        if ($this->em === null) {
            $this->em = $this->getContainer()->get('doctrine')->getManager();
        }

        $reminders = $this->em->getRepository('AppBundle:Reminder')->findAll();

        foreach ($reminders as $reminder) {
            $output->writeln(
                '(' . $reminder->getId() . ') '
                . '<info>' . $reminder->getMessage() . '</info> do wysłania w dniu '
                . '<info>' . $reminder->getSendAt()->format('d.m.Y H:i') . '</info>'
            );
        }
    }
}