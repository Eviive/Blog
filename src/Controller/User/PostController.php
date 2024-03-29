<?php

namespace App\Controller\User;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, PaginatorInterface $paginator): Response
    {
        [ 'featured' => $featured, 'pagination' => $pagination ] = $this->getPosts($postRepository, $paginator);

        return $this->render('pages/user/post/index.html.twig', [
            'featured' => $featured,
            'posts' => $pagination ? $pagination->getItems() : []
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/infinite-scroll', name: 'app_home_infinite_scroll', methods: ['GET'])]
    public function infiniteScroll(Request $request, PostRepository $postRepository, PaginatorInterface $paginator): JsonResponse
    {
        $pageNumber = $request->query->getInt('page', 2);

        [ 'pagination' => $pagination ] = $this->getPosts($postRepository, $paginator, $pageNumber);

        $hasNextPage = $pagination && $pagination->getCurrentPageNumber() < ($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage());

        $html = $this->renderView('pages/user/post/_infinite_scroll.html.twig', [
            'posts' => $pagination ? $pagination->getItems() : []
        ]);

        return new JsonResponse([
            'html' => $html,
            'hasNextPage' => $hasNextPage
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    private function getPosts(PostRepository $postRepository, PaginatorInterface $paginator, int $pageNumber = 1): array
    {
        $featured = $postRepository->findMostRecentPost();

        $pagination = $featured ? $paginator->paginate(
            $postRepository->findAllExcept($featured->getId()),
            max($pageNumber, 1),
            4
        ) : null;

        return [
            'featured' => $featured,
            'pagination' => $pagination
        ];
    }

    #[Route('/post', name: 'app_home_post', methods: ['GET'])]
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

    #[Route('/post/{slug}', name: 'app_home_post_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($this->getUser() && $form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', ['message' => 'Please check your form for errors.']);
            } else {
                $comment->setUser($this->getUser());
                $comment->setPost($post);

                $commentRepository->save($comment, true);

                $this->addFlash('success', ['message' => 'Comment posted successfully, awaiting validation by the moderation team.']);

                return $this->redirectToRoute('app_home_post_show', [
                    'slug' => $post->getSlug(),
                ]);
            }
        }

        return $this->render('pages/user/post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    // search route
    #[Route('/search', name: 'app_home_search', methods: ['GET'])]
    public function search(Request $request, PostRepository $postRepository): JsonResponse
    {
        $search = $request->query->get('q');

        if (!$search) {
            return new JsonResponse([], 400);
        }

        $posts = $postRepository->findBySearch($search);

        $json = [];

        foreach ($posts as $post) {
            $json[] = [
                'title' => $post->getTitle(),
                'url' => $this->generateUrl('app_home_post_show', ['slug' => $post->getSlug()])
            ];
        }

        return new JsonResponse($json);
    }
}
