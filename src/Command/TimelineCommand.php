<?php

namespace App\Command;

use App\Helper\AgoHelper;
use App\Repository\TwittererRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TimelineCommand extends Command
{
    protected static $defaultName = 'app:twitter:timeline';

    /**
     * @var TwittererRepository
     */
    protected $twitterers;

    /**
     * @var AgoHelper
     */
    protected $ago;

    public function __construct(TwittererRepository $twitterers, AgoHelper $ago)
    {
        $this->twitterers = $twitterers;
        $this->ago = $ago;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Show the timeline for a user')
            ->addArgument('username', InputArgument::REQUIRED, 'The user\'s name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        $user = $this->twitterers->findOneByName($username);
        foreach ($user->getPosts() as $post) {
            $io->success(sprintf("%s - %s (%s)\n", $user->getName(), $post->getMessage(),
                $this->ago->ago($post->getCreated())));
        }
    }
}
