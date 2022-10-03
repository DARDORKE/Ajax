<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render("post/index.html.twig");
    }

    /**
     * @Route("/posts", name="read_posts")
     */
    public function read(PostRepository $postRepository) {
        $posts = $postRepository->findAll();
        $arrayOfPosts = [];
        foreach ($posts as $post) {
            $arrayOfPosts[] = $post->toArray();
        }
        return $this->json($arrayOfPosts);
    }
}
