<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\LinkChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CheckLinksCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:check';

    public function __construct(private LinkChecker $linkChecker)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = $input->getArgument('url');
        $this->linkChecker->checkUrl($url);

        $output->writeln('Done!');

        return 0;
    }
}
