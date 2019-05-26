<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Twitterer extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $frenchSoldier = new \App\Entity\Twitterer();
        $frenchSoldier->setName('frenchie');
        $posts = [
            'PT5M38S' => 'I blow my nose at you, so called Arthoouur keeeeeiiiiing, you and your silly English Kiiiiiinnnnnniggits!',
            'PT10M15S' => 'I fart in your general direction! Your mother was a \'amster, and your father smelt of elderberries!',
            'PT15M30S' => 'My name is Francoise Castle-Guard, and this is my first message.',
        ];
        foreach ($posts as $int => $msg) {
            $post = new \App\Entity\Post();
            $post->setMessage($msg);
            $post->setTwitterer($frenchSoldier);
            $date = new \DateTime();
            $date->sub(new \DateInterval($int));
            $post->setCreated($date);
            $frenchSoldier->addPost($post);
            $manager->persist($post);
        }
        $manager->persist($frenchSoldier);
        $manager->flush();

        $duke = new \App\Entity\Twitterer();
        $duke->setName('duke');
        $posts = [
            'PT4M38S' => '...and I\'m aaaallll outta bubblegum.',
            'PT9M15S' => 'I\'m here to kick ass and chew bubblegum...',
            'PT14M30S' => 'My name is Duke Nukem, and this is my first message.',
        ];
        foreach ($posts as $int => $msg) {
            $post = new \App\Entity\Post();
            $post->setMessage($msg);
            $post->setTwitterer($duke);
            $date = new \DateTime();
            $date->sub(new \DateInterval($int));
            $post->setCreated($date);
            $manager->persist($post);
            $duke->addPost($post);
        }
        $manager->persist($duke);
        $manager->flush();

        $mitch = new \App\Entity\Twitterer();
        $mitch->setName('mitch');
        $posts = [
            'PT3M38S' => 'I\'m gonna fix that last joke by taking out all the words and adding new ones.',
            'PT8M15S' => 'Rice is great when you\'re hungry and you want two thousand of something.',
            'PT13M30S' => 'My name is Mitch Hedburg, and this is my first message.',
        ];
        foreach ($posts as $int => $msg) {
            $post = new \App\Entity\Post();
            $post->setMessage($msg);
            $post->setTwitterer($mitch);
            $date = new \DateTime();
            $date->sub(new \DateInterval($int));
            $post->setCreated($date);
            $manager->persist($post);
            $mitch->addPost($post);
        }
        $manager->persist($mitch);
        $manager->flush();

        $bill = new \App\Entity\Twitterer();
        $bill->setName('bill');
        $posts = [
            'PT2M38S' => 'I gotta be honest with you. I\'m kind of jealous of the way my dad gets to talk to my mom sometimes. Where are all those old-school women you can just take your day out on? When did they stop making those angels?',
            'PT7M15S' => 'God\'s everywhere, but I gotta go down (to church) to see him? Really? And he\'s mad at me down there, and I owe you money?',
            'PT12M30S' => 'My name is Bill Burr, and this is my first message.',
        ];
        foreach ($posts as $int => $msg) {
            $post = new \App\Entity\Post();
            $post->setMessage($msg);
            $post->setTwitterer($bill);
            $date = new \DateTime();
            $date->sub(new \DateInterval($int));
            $post->setCreated($date);
            $manager->persist($post);
            $bill->addPost($post);
        }
        $bill->addFollower($duke);
        $bill->addFollower($mitch);
        $manager->persist($bill);

        $manager->flush();
    }
}
