<?php

namespace Command\EmailReminder;

use Doctrine\Common\Persistence\ObjectManager;
use Reminder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
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
            ->setName('reminder:add')
            ->setDescription('Tworzy nowe przypomnienie.')
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Wiadomość, która zostanie wysłana na dany adres e-mail.'
            )
            ->addArgument(
                'datetime',
                InputArgument::REQUIRED,
                'Czas, kiedy wiadomość zostanie wysłana.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');

        // Jeśli format daty jest nieprawidłowy, wyświetla komunikat.
        try {
            $dateTime = new \DateTime($input->getArgument('datetime'));
        } catch (\Exception $e) {
            $formatter = $this->getHelper('formatter');
            $formattedBlock = $formatter->formatBlock(array(
                'Błąd!', 'Niepoprawny format daty. '
                 . 'Proszę zapoznać się z obsługiwanymi formatami pod adresem '
                 . 'http://php.net/manual/en/datetime.formats.php'
            ), 'error', true);
            $output->writeln($formattedBlock);
            return;
        }

        // Zapisuje nowe powiadomienie.
        $reminder = new Reminder();
        $reminder->setMessage($message);
        $reminder->setSendAt($dateTime);
        $this->em->persist($reminder);
        $this->em->flush();

        $output->writeln(
            'Wiadomość <info>' . $message . '</info> zostanie wysłana w dniu '
            . '<info>' . $dateTime->format('d.m.Y H:i') . '</info>'
        );
    }
}