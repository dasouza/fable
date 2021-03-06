<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Entity\Tag;

class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
    * @return Tag[] Returns an array of all Tag objects
    */
    public function findMostUsed(int $limit): array
    {
        $query = $this->createQueryBuilder('t')
            ->addSelect('COUNT(a.id) AS HIDDEN counter')
            ->join('t.articles', 'a')
            ->addOrderBy('counter', 'DESC')
            ->addOrderBy('t.id', 'ASC')
            ->groupBy('t.id')
            ->setMaxResults($limit)
            ->getQuery()
            ->setHydrationMode(AbstractQuery::HYDRATE_ARRAY)
      ;

        $paginator = new Paginator($query, true);

        return $paginator->getIterator()->getArrayCopy();
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
