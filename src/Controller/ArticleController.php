<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use App\Repository\ArticleRepository;

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

    public function __construct(Environment $twig, ArticleRepository $articleRepository)
    {
        $this->twig = $twig;
        $this->articleRepository = $articleRepository;
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

    public function show(Request $request) : Response
    {
        $article = $this->articleRepository->findOnePublishedBySlug($request->get('slug'));

        return new Response($this->twig->render('article/show.html.twig', [
            'article' => $article,
        ]), Response::HTTP_OK);
    }
}
