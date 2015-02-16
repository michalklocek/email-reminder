<?php

namespace Command\EmailReminder;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
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
            ->setName('reminder:delete')
            ->setDescription('Usuwa przypomnienie.')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'ID wiadomości do usunięcia. Podaj "all" aby wyczyścić listę.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reminderId = $input->getArgument('id');

        // Jeśli użytkownik podał wartość "all", usuwa wszystkie przypomnienia.
        if ($reminderId === 'all') {
            $this->em->createQuery('DELETE FROM Reminder')->execute();
            $output->writeln(
                'Wszystkie przypomnienia zostały usunięte.'
            );
            return;
        }

        $reminder = $this->em->getRepository('Reminder')->find($reminderId);

        // Jeśli przypomnienie o podanym ID nie istnieje, wyświetla komunikat.
        if (!$reminder) {
            $formatter = $this->getHelper('formatter');
            $formattedBlock = $formatter->formatBlock(array(
                'Błąd!', 'Przypomnienie ID = ' . $reminderId . ' nie istnieje.'
            ), 'error', true);
            $output->writeln($formattedBlock);
            return;
        }

        // Usuwa przypomnienie o podanym ID.
        $this->em->remove($reminder);
        $this->em->flush();

        $output->writeln(
            'Przypomnienie <info>' . $reminder->getMessage() . '</info> zostało usunięte.'
        );
    }
} 