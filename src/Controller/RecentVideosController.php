<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecentVideosController extends AbstractController
{
    #[Route('/recent-videos', name: 'app_recent_videos')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {


        $categoriesWithQuestions = $entityManager->getRepository(Category::class)->findCategoriesWithQuestions();

        return $this->render('recent_videos/index.html.twig', [
            'categoriesWithQuestions' => $categoriesWithQuestions
        ]);
    }
}
