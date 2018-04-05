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
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults('6')
            ->getQuery()
            ->getResult()
            ;

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

    public function lastSection($value)
    {
        return  $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->leftJoin('post.tags', 'tag')
            ->where('tag.name = :value')->setParameter('value', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function fourSection($value)
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->leftJoin('post.tags', 'tag')
            ->where('tag.name = :value')->setParameter('value', $value)
            ->setFirstResult(1)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;

    }

    public function infoSideBar()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults('10')
            ->getQuery()
            ->getResult()
        ;
    }

    public function finByTag($value)
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->leftJoin('post.tags', 'tag')
            ->where('tag.name = :value')->setParameter('value', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    public function slider($value)
    {
        return $this->createQueryBuilder('post')
            ->where('post.id = :value')->setParameter('value', $value)
            ->getQuery()
            ->getResult()
        ;
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
