<?php

namespace App\Controller;

use App\Entity\FavPost;
use App\Entity\Post;
use App\Repository\FavPostRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route("/post/{id}/favorite", name: "post_favorite")]
    public function addToFavorites(Post $post, EntityManagerInterface $em, FavPostRepository $favRepo): Response {
        $user = $this->getUser();
        if(!$user) {
            return $this->json(["code" => 403, "message" => "Unauthorized"], 403);
        }
        if($post->isFavByUser($user)) {
            $favorite = $favRepo->findOneBy([
                "post" => $post,
                "user" => $user
            ]);
            $em->remove($favorite);
            $em->flush();
            return $this->json([
                "code" => 200,
                "message" => "Article retiré des favoris"
            ], 200);
        }

        $like = (new FavPost())
            ->setPost($post)
            ->setUser($user);
        $em->persist($like);
        $em->flush();

        return $this->json([
            "code" => 200,
            "message" => "Article ajouté aux favoris"
        ], 200);
    }
}
