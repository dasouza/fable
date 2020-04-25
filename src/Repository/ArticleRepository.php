<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Article;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
    * @return Article[] Returns an array of the latest Article objects
    */
    public function findLatest(int $limit): array
    {
        $query = $this->createQueryBuilder('a')
            ->select('a', 'c', 't')
            ->join('a.category', 'c')
            ->leftJoin('a.tags', 't')
            ->andWhere('a.published = :published')
            ->orderBy('a.created', 'ASC')
            ->addOrderBy('a.id', 'ASC')
            ->setParameter('published', true)
            ->setMaxResults($limit)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
        ;

        $paginator = new Paginator($query, true);

        return $paginator->getIterator()->getArrayCopy();
    }

    /**
    * @return Article[] Returns an array of all Article objects
    */
    public function findAllPublished(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'c', 't')
            ->join('a.category', 'c')
            ->leftJoin('a.tags', 't')
            ->andWhere('a.published = :published')
            ->addOrderBy('a.created', 'ASC')
            ->addOrderBy('a.id', 'ASC')
            ->setParameter('published', true)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }

    /**
    * @return Article[] Returns an array of all Article objects
    */
    public function findAllPublishedByCategory(string $slug): array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'c', 't')
            ->join('a.category', 'c')
            ->leftJoin('a.tags', 't')
            ->andWhere('c.slug = :slug')
            ->andWhere('a.published = :published')
            ->orderBy('a.created', 'ASC')
            ->addOrderBy('a.id', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }

    /**
    * @return Article[] Returns an array of all Article objects
    */
    public function findAllPublishedByTag(string $slug): array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'c', 't1')
            ->join('a.category', 'c')
            ->join('a.tags', 't1')
            ->join('a.tags', 't2')
            ->andWhere('t2.slug = :slug')
            ->andWhere('a.published = :published')
            ->orderBy('a.created', 'ASC')
            ->addOrderBy('a.id', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('published', true)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }

    /**
    * @return Article Returns an Article object
    */
    public function findOnePublishedBySlug(string $category, string $slug): ?array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'c', 't')
            ->join('a.category', 'c')
            ->leftJoin('a.tags', 't')
            ->andWhere('c.slug = :category')
            ->andWhere('a.published = :published')
            ->andWhere('a.slug = :slug')
            ->setParameter('category', $category)
            ->setParameter('published', true)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
}
