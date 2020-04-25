<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Category;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
    * @return Category[] Returns an array of all Category objects
    */
    public function findAllWithArticles(int $limit): array
    {
        $query = $this->createQueryBuilder('c')
            ->select('c', 'COUNT(a.id) AS HIDDEN counter')
            ->join('c.articles', 'a')
            ->orderBy('counter', 'ASC')
            ->groupBy('c.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
        ;

        $paginator = new Paginator($query, true);

        return $paginator->getIterator()->getArrayCopy();
    }

    /**
    * @return Category Returns a Category object
    */
    public function findOneWithArticlesBySlug(string $slug): ?array
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.articles', 'a', 'WITH', 'a.published = :published')
            ->andWhere('c.slug = :slug')
            ->setParameter('published', true)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY)
        ;
    }
}
