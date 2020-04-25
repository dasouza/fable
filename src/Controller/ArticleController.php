<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

class ArticleController
{
    /**
    * @var Environment
    */
    private $twig;

    /**
    * @var ArticleRepository
    */
    private $articleRepository;

    /**
    * @var CategoryRepository
    */
    private $categoryRepository;

    /**
    * @var TagRepository
    */
    private $tagRepository;

    public function __construct(Environment $twig, ArticleRepository $articleRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository)
    {
        $this->twig = $twig;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    public function home() : Response
    {
        $articles = $this->articleRepository->findLatest(2);

        return new Response($this->twig->render('article/home.html.twig', [
            'articles' => $articles,
        ]), Response::HTTP_OK);
    }

    public function index(string $_format) : Response
    {
        $articles = $this->articleRepository->findAllPublished();

        $response = new Response($this->twig->render('article/index.'.$_format.'.twig', [
            'articles' => $articles,
        ]), Response::HTTP_OK);

        if ($_format == 'xml') {
            $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        }
        
        return $response;
    }

    public function categoryIndex(Request $request) : Response
    {
        if ($this->categoryRepository->findOneBySlug($request->get('slug')) == null) {
            throw new NotFoundHttpException();
        }

        $articles = $this->articleRepository->findAllPublishedByCategory($request->get('slug'));

        return new Response($this->twig->render('article/tagIndex.html.twig', [
            'articles' => $articles,
        ]), Response::HTTP_OK);
    }

    public function tagIndex(Request $request) : Response
    {
        if ($this->tagRepository->findOneBySlug($request->get('slug')) == null) {
            throw new NotFoundHttpException();
        }

        $articles = $this->articleRepository->findAllPublishedByTag($request->get('slug'));

        return new Response($this->twig->render('article/tagIndex.html.twig', [
            'articles' => $articles,
        ]), Response::HTTP_OK);
    }

    public function show(Request $request) : Response
    {
        $article = $this->articleRepository->findOnePublishedBySlug($request->get('category'), $request->get('slug'));

        return new Response($this->twig->render('article/show.html.twig', [
            'article' => $article,
        ]), Response::HTTP_OK);
    }

    public function categoryListFragment(int $max = 10) : Response
    {
        $categories = $this->categoryRepository->findAllWithArticles(10);

        return new Response($this->twig->render('article/fragment/categoryList.html.twig', [
            'categories' => $categories,
        ]), Response::HTTP_OK);
    }

    public function tagListFragment(int $max = 10) : Response
    {
        $tags = $this->tagRepository->findMostUsed(10);

        return new Response($this->twig->render('article/fragment/tagList.html.twig', [
            'tags' => $tags,
        ]), Response::HTTP_OK);
    }
}
