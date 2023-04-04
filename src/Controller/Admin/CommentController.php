<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('pages/admin/comment/index.html.twig', [
            'invalidComments' => $commentRepository->findAllInvalid(),
        ]);
    }

    #[Route('/{id}/validate', name: 'app_comment_validate', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function validate(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid('validate'.$comment->getId(), $request->request->get('_token'))) {
            $comment->setValid(true);
            $commentRepository->save($comment, true);

            $this->addFlash('success', ['message' => 'Comment successfully validated.']);
        } else {
            $this->addFlash('warning', ['message' => 'Invalid CSRF token, please try again.']);
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_comment_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);

            $this->addFlash('success', ['message' => 'Comment successfully deleted.']);
        } else {
            $this->addFlash('warning', ['message' => 'Invalid CSRF token, please try again.']);
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
