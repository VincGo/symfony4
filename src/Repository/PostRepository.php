<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function lastNews()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults('6')
            ;
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function lastArticle()
    {
        $qb = $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->leftJoin('post.tags', 'tag')
            ->where("tag.name = 'article'")
            ->setMaxResults('4')
        ;
        $query = $qb->getQuery();

        return $query->execute();
    }


    public function infoSideBar()
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults('10')
        ;

        $query =$qb->getQuery();

        return $query->execute();
    }

    public function finByTag($value)
    {
        $qb = $this->createQueryBuilder('post')
            ->leftJoin('post.tags', 'tag')
            ->where('tag.name = :value')->setParameter('value', $value)
            ;
        $query = $qb->getQuery();

        return $query->execute();
    }

    public function slider($value)
    {
        $qb = $this->createQueryBuilder('post')
            ->where('post.id = :value')->setParameter('value', $value)
        ;
        $query = $qb->getQuery();

        return $query->execute();
    }
    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
