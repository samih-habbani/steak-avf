<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function showCategories(EntityManagerInterface $entityManager): Response
    {
        $categoriesWithQuestions = $entityManager->getRepository(Category::class)->findCategoriesWithQuestions();
    
        return $this->render('category/all.html.twig', [
            'categoriesWithQuestions' => $categoriesWithQuestions,
        ]);
    }
    

    #[Route('/category/{id}', name: 'app_category', requirements: ['id' => '\d+'])]
    public function showCategory(EntityManagerInterface $entityManager, $id): Response
    {
        $category = $entityManager->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        
        $questions = $category->getQuestions();

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'questions' => $questions,
        ]);
    }
}
