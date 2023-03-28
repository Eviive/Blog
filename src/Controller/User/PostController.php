<?php

namespace App\Controller\User;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_home_index')]
    public function index(PostRepository $postRepository): Response
    {
        $featured = $postRepository->findFeaturedPost();

        $posts = $featured ? $postRepository->findAllExcept($featured->getId()) : [];

        return $this->render('pages/user/post/index.html.twig', [
            'featured' => $featured,
            'posts' => $posts,
        ]);
    }

    #[Route('/post', name: 'app_home_post')]
    public function post(Request $request, PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        $pageNumber = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $postRepository->findPagination(),
            max($pageNumber, 1),
            10
        );

        return $this->render('pages/user/post/post.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/post/{slug}', name: 'app_home_post_show')]
    public function show(Post $post): Response
    {
        return $this->render('pages/user/post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
