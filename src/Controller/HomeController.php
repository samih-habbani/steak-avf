<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        // // get all questions from database
        // $questions = $entityManager->getRepository(Question::class)->findAll();

        // get all recent from database
        $questions = $entityManager->getRepository(Question::class)->findBy([], ['creationDate' => 'DESC']);

        // get all categories from database
        $categories = $entityManager->getRepository(Category::class)->findAll();

        // Get categories with associated questions
        $categoriesWithQuestions = $entityManager->getRepository(Category::class)->findCategoriesWithQuestions();


        

        // Paginate the recent questions
        $pagination = $paginator->paginate(
            $questions,
            $request->query->getInt('page', 1), // Current page number, default to 1 if not provided in the query string
            3 // Number of items per page
        );



        return $this->render('home/index.html.twig', [
            'questions' => $questions,
            'categories' => $categories,
            'pagination' => $pagination,
            'categoriesWithQuestions' => $categoriesWithQuestions
        ]);
    }
}
