<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
    * @return Tag[] Returns an array of all Tag objects
    */
    public function findAllWithArticles(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->addSelect('COUNT(a.id) AS HIDDEN counter')
            ->join('t.articles', 'a')
            ->orderBy('counter', 'ASC')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
    }

    /**
    * @return Tag Returns a Tag object
    */
    public function findOneWithArticlesBySlug(string $slug): ?array
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->join('t.articles', 'a', 'WITH', 'a.published = :published')
            ->andWhere('t.slug = :slug')
            ->setParameter('published', true)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
}
