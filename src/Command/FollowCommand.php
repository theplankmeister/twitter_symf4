<?php

namespace App\Command;

use App\Repository\TwittererRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FollowCommand extends Command
{
    protected static $defaultName = 'app:twitter:follow';

    /**
     * @var TwittererRepository
     */
    protected $twitterers;

    /**
     * @var ObjectManager
     */
    protected $manager;

    public function __construct(TwittererRepository $twitterers, ObjectManager $manager)
    {
        $this->twitterers = $twitterers;
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Follows another user')
            ->addArgument('username', InputArgument::REQUIRED, 'The user\'s name')
            ->addArgument('target', InputArgument::REQUIRED, 'The user to follow')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $targetname = $input->getArgument('target');

        $user = $this->twitterers->findOneByName($username);
        $target = $this->twitterers->findOneByName($targetname);
        $user->addFollower($target);
        $this->manager->persist($user);
        $this->manager->flush();

        $io->success(sprintf('%s now following %s', $username, $targetname));
    }
}
