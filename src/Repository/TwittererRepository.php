<?php

namespace App\Repository;

use App\Entity\Twitterer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Twitterer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Twitterer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Twitterer[]    findAll()
 * @method Twitterer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwittererRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Twitterer::class);
    }

    public function findOneByName(string $name): ?Twitterer
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
