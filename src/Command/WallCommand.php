<?php

namespace App\Command;

use App\Entity\Post;
use App\Helper\AgoHelper;
use App\Repository\TwittererRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WallCommand extends Command
{
    protected static $defaultName = 'app:twitter:wall';

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
            ->setDescription('Displays posts from all subscriptions')
            ->addArgument('username', InputArgument::REQUIRED, 'The user\'s name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');

        $user = $this->twitterers->findOneByName($username);
        $posts = $user->getPosts();
        foreach ($user->getFollowers() as $follower) {
            foreach ($follower->getPosts() as $followerPost) {
                $posts->add($followerPost);
            }
        }

        $postArr = $posts->toArray();
        uasort($postArr, function ($a, $b) {
            return $a->getCreated() < $b->getCreated();
        });

        /** @var Post $post */
        foreach ($postArr as $post) {
            $io->success(sprintf("%s - %s (%s)\n", $post->getTwitterer()->getName(), $post->getMessage(),
                $this->ago->ago($post->getCreated())));
        }
    }
}
