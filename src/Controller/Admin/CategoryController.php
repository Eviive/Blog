<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('pages/admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_category_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Category $category): Response
    {
        return $this->render('pages/admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', 'Please check your form for errors.');
            } else {
                $categoryRepository->save($category, true);

                $this->addFlash('success', 'Category created successfully.');

                return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pages/admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_category_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', 'Please check your form for errors.');
            } else {
                $categoryRepository->save($category, true);

                $this->addFlash('success', [
                    'message' => 'Category updated successfully, click here to see it.',
                    'link' => $this->generateUrl('app_home_category_show', ['id' => $category->getId()])
                ]);

                return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('pages/admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_category_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);

            $this->addFlash('success', 'Category deleted successfully.');
        } else {
            $this->addFlash('warning', 'Invalid CSRF token, please try again.');
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
