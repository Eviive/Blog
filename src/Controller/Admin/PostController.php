<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('pages/admin/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository, SluggerInterface $slugger): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', ['message' => 'Please check your form for errors.']);
            } else {
                $post->setSlug($slugger->slug($post->getTitle())->lower());

                $postRepository->save($post, true);

                $this->addFlash('success', ['message' => 'Post created successfully.']);

                return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('pages/admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', ['message' => 'Please check your form for errors.']);
            } else {
                $post->setSlug($slugger->slug($post->getTitle())->lower());
                $post->setUpdatedAt(new \DateTime());

                $postRepository->save($post, true);

                if ($post->getPublishedAt()) {
                    $flashContent = [
                        'message' => 'Post updated successfully, click here to see it.',
                        'link' => $this->generateUrl('app_home_post_show', ['slug' => $post->getSlug()])
                    ];
                } else {
                    $flashContent = ['message' => 'Post updated successfully.'];
                }

                $this->addFlash('success', $flashContent);

                return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('pages/admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);

            $this->addFlash('success', ['message' => 'Post deleted successfully.']);
        } else {
            $this->addFlash('warning', ['message' => 'Invalid CSRF token, please try again.']);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slug}/publish', name: 'app_post_publish', methods: ['POST'])]
    public function publish(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('publish'.$post->getId(), $request->request->get('_token'))) {
            if ($post->getPublishedAt()) {
                $post->setPublishedAt(null);

                $this->addFlash('success', ['message' => 'Post successfully unpublished.']);
            } else {
                $post->setPublishedAt(new \DateTime());

                $this->addFlash('success', [
                    'message' => 'Post successfully published, click here to see it.',
                    'link' => $this->generateUrl('app_home_post_show', ['slug' => $post->getSlug()])
                ]);
            }
            $postRepository->save($post, true);
        } else {
            $this->addFlash('warning', ['message' => 'Invalid CSRF token, please try again.']);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
