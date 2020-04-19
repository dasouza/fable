<?php

namespace App\Tests\Repository;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testFindLatest()
    {
        $articles = $this->entityManager
          ->getRepository(Article::class)
          ->findLatest(2)
      ;

        $this->assertEquals(2, count($articles));
        $this->assertEquals('first-article', $articles[0]->getSlug());
    }

    public function testFindAllPublished()
    {
        $articles = $this->entityManager
          ->getRepository(Article::class)
          ->findAllPublished()
      ;

        $this->assertGreaterThan(0, count($articles));
        $this->assertEquals('first-article', $articles[0]->getSlug());
    }

    public function testFindOnePublishedBySlug()
    {
        $article = $this->entityManager
          ->getRepository(Article::class)
          ->findOnePublishedBySlug('first-article')
      ;

        $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', $article->getSummary());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
