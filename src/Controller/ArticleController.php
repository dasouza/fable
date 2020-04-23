<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;
use App\Repository\ArticleRepository;
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
    * @var TagRepository
    */
    private $tagRepository;

    public function __construct(Environment $twig, ArticleRepository $articleRepository, TagRepository $tagRepository)
    {
        $this->twig = $twig;
        $this->articleRepository = $articleRepository;
        $this->tagRepository = $tagRepository;
    }

    public function home() : Response
    {
        $articles = $this->articleRepository->findLatest(2);

        return new Response($this->twig->render('article/home.html.twig', [
            'articles' => $articles,
        ]), Response::HTTP_OK);
    }

    public function index() : Response
    {
        $articles = $this->articleRepository->findAllPublished();

        return new Response($this->twig->render('article/index.html.twig', [
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
        $article = $this->articleRepository->findOnePublishedBySlug($request->get('slug'));

        return new Response($this->twig->render('article/show.html.twig', [
            'article' => $article,
        ]), Response::HTTP_OK);
    }
}