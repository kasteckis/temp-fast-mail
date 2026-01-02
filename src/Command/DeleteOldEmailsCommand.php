<?php

namespace App\Command;

use App\Service\Handler\ReceivedEmail\DeleteOldReceivedEmailsHandler;
use App\Service\Handler\TemporaryEmailBox\DeleteOldEmailBoxesHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:delete-old-emails',
    description: 'Deletes emails and email boxes older than 24 hours (or another specified time period via .env).',
)]
class DeleteOldEmailsCommand extends Command
{
    public function __construct(
        private DeleteOldReceivedEmailsHandler $deleteOldReceivedEmailsHandler,
        private DeleteOldEmailBoxesHandler $deleteOldEmailBoxesHandler,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $olderThanHours = $_ENV['DELETE_EMAILS_AND_INBOXES_OLDER_THAN_HOURS'];

        $deleteOlderThan = new \DateTimeImmutable('-' . $olderThanHours . ' hours');

        $deletedEmailCount = $this->deleteOldReceivedEmailsHandler->deleteOlderThan($deleteOlderThan);

        $io->success('Deleted ' . $deletedEmailCount . ' old emails.');

        $deletedInboxCount = $this->deleteOldEmailBoxesHandler->deleteOlderThan($deleteOlderThan);

        $io->success('Deleted ' . $deletedInboxCount . ' old inboxes.');

        $io->success(sprintf(
            'You have successfully deleted emails and email boxes that were older than %s hours. Older than %s date',
            $olderThanHours, $deleteOlderThan->format('Y-m-d H:i:s')
        ));

        return Command::SUCCESS;
    }
}
