<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;
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

    #[Route('/{slug}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('pages/admin/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository, SluggerInterface $slugger, HtmlSanitizerInterface $sanitizer): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', 'Please check your form for errors.');
            } else {
                $post->setSlug($slugger->slug($post->getTitle())->lower());
                $post->setContent($sanitizer->sanitize($post->getContent()));

                $postRepository->save($post, true);

                $route = $post->getPublishedAt()
                    ? 'app_home_post_show'
                    : 'app_post_show';

                $this->addFlash('success', [
                    'message' => 'Post created successfully, click here to see it.',
                    'link' => $this->generateUrl($route, ['slug' => $post->getSlug()])
                ]);

                return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pages/admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository, SluggerInterface $slugger, HtmlSanitizerInterface $sanitizer): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', 'Please check your form for errors.');
            } else {
                $post->setSlug($slugger->slug($post->getTitle())->lower());
                $post->setContent($sanitizer->sanitize($post->getContent()));

                $postRepository->save($post, true);

                $route = $post->getPublishedAt()
                    ? 'app_home_post_show'
                    : 'app_post_show';

                $this->addFlash('success', [
                    'message' => 'Post updated successfully, click here to see it.',
                    'link' => $this->generateUrl($route, ['slug' => $post->getSlug()])
                ]);

                return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pages/admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);

            $this->addFlash('success', 'Post deleted successfully.');
        } else {
            $this->addFlash('warning', 'Invalid CSRF token, please try again.');
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
