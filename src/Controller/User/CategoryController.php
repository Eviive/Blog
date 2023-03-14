<?php

namespace App\Controller\User;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends AbstractController
{
    public function getPopularCategories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('components/_nav.html.twig', [
            'categories' => $categoryRepository->findPopularCategories(),
        ]);
    }
}
