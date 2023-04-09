<?php

namespace App\Controller\User;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    #[Route('', name: 'app_home_category', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('pages/user/category/index.html.twig', [
            'categories' => $categoryRepository->findAllNotEmptyAndPostsCount(),
        ]);
    }

    #[Route('/{id}', name: 'app_home_category_show', methods: ['GET'])]
    public function show(Category $category, Request $request, PaginatorInterface $paginator, PostRepository $postRepository): Response
    {
        $pageNumber = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $postRepository->findPaginatedByCategoryId($category->getId()),
            max($pageNumber, 1),
            10
        );

        return $this->render('pages/user/category/show.html.twig', [
            'category' => $category,
            'pagination' => $pagination
        ]);
    }

    public function getPopularCategories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('components/_nav.html.twig', [
            'categories' => $categoryRepository->findPopularCategories(),
        ]);
    }
}
