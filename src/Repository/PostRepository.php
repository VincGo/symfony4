<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PostRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function lastArticle()
    {
        $qb = $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->leftJoin('post.tags', 'tag')
            ->where("tag.name = 'article'")
            ->setMaxResults(Post::NUMBER_OF_RELATED_POSTS)
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
            ->setMaxResults(Post::NUMBER_OF_MAIN_POSTS)
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
            ->setFirstResult(Post::NUMBER_OF_MAIN_POSTS)
            ->setMaxResults(Post::NUMBER_OF_SECTION_POSTS)
            ->getQuery()
            ->getResult()
        ;

    }

    public function infoSideBar()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(Post::NUMBER_OF_SIDEBAR_POSTS)
            ->getQuery()
            ->getResult()
        ;
    }

    public function finByTag(Tag $tag)
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.id', 'DESC')
            ->innerJoin('post.tags', 'tag')
            ->where('tag.name = :value')->setParameter('value', $tag->getName())
            ->getQuery()
            ->getResult()
            ;
    }

    public function relatedArticle(Post $post)
    {
        $ids = $this->createQueryBuilder('post')
            ->select('post.id, COUNT(tag) as HIDDEN tagsCpt')
            ->groupBy('post.id')
            ->orderBy('post.id', 'DESC')
            ->innerJoin('post.tags', 'tag')
            ->where('tag in (:tags)')
            ->setParameter('tags', $post->getTags())
            ->having('tagsCpt = :nbMatchRequired')
            ->setParameter('nbMatchRequired', count($post->getTags()))
            ->setMaxResults(Post::NUMBER_OF_RELATED_POSTS)
            ->getQuery()
            ->getArrayResult()
            ;

        return $this->createQueryBuilder('post')
            ->where('post.id IN (:ids)')
            ->setParameter('ids',$ids)
            ->getQuery()->getResult();
    }

    public function fourSlider()
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.slider', 'DESC')
            ->setMaxResults(Post::NUMBER_OF_RELATED_POSTS)
            ->getQuery()
            ->getResult()
        ;
    }

    public function allArticle()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
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
