<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\Twitterer;
use App\Repository\TwittererRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PostCommand extends Command
{
    protected static $defaultName = 'app:twitter:post';

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
            ->setDescription('Posts a new message for a given user')
            ->addArgument('username', InputArgument::REQUIRED, 'The user\'s name')
            ->addArgument('message', InputArgument::REQUIRED, 'The message to post')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $message = $input->getArgument('message');

        $user = $this->twitterers->findOneByName($username);
        if (is_null($user)) {
            $user = new Twitterer();
            $user->setName($username);
            $this->manager->persist($user);
        }

        $post = new Post();
        $post->setMessage($message);
        $post->setTwitterer($user);
        $post->setCreated(new \DateTime());
        $this->manager->persist($post);
        $user->addPost($post);
        $this->manager->flush();

        $io->success('Message posted.');
    }
}
