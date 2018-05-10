<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ChatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function findLastMsg($id, Tag $tag)
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->where('c.id > :id')
            ->setParameter('id', $id)
            ->andWhere( 'c.team in (:tag)')
            ->setParameter('tag', $tag->getName())
            ->getQuery()
            ->getResult()

            ;
    }

    public function findByTeam(Tag $tag)
    {
        return $this->createQueryBuilder('t')
            ->where('t.team in (:tag)')
            ->setParameter('tag', $tag->getName())
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
