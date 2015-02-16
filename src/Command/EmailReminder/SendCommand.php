<?php

namespace Command\EmailReminder;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendCommand extends Command
{
    protected $em;
    protected $mailer;
    protected $twig;

    public function __construct(ObjectManager $em, \Swift_Mailer $mailer = null, \Twig_Environment $twig)
    {
        parent::__construct();
        $this->em = $em;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    protected function configure()
    {
        $this
            ->setName('reminder:send')
            ->setDescription('Wysyła powiadomienia');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists(__DIR__ . '/../../../email.txt')) {
            $formatter = $this->getHelper('formatter');
            $formattedBlock = $formatter->formatBlock(array(
                'Błąd!', 'Proszę najpierw zdefiniować adres e-mail. Użyj reminder:set'
            ), 'error', true);
            $output->writeln($formattedBlock);
        }

        $email = file_get_contents(__DIR__ . '/../../../email.txt');

        // Pobiera przypomnienia do wysłania.
        $reminders = $this->em->getRepository('Reminder')->findToSend();

        foreach ($reminders as $reminder) {
            $reminder->setSent(true);
        }

        $this->em->flush();

        // Create a message
        $message = \Swift_Message::newInstance('Wonderful Subject')
            ->setFrom('michal.klocek@polcode.net')
            ->setTo($email)
            ->setBody($this->twig->render(
                'email.txt.twig', array('reminders' => $reminders)
            ));
        ;

        // Send the message
        $this->mailer->send($message);

        $output->writeln(
            'Wysłano <info>' . count($reminders) . '</info> przypomnień na adres '
            . '<info>' . $email . '</info>.'
        );
    }
}