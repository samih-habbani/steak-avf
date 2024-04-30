<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(EntityManagerInterface $entityManager, Request $request): Response
    {

        $search = $request->query->get('search');

        if(is_null($search) || empty($search)) {
            return $this->redirectToRoute('app_home');
        }


        $questions = $entityManager->getRepository(Question::class)->findBySearch($search);


        $data = array();

        foreach ($questions as $key => $question) {
            $data[$key]['id'] = $question->getId();
            $data[$key]['title'] = $question->getTitle();
            $data[$key]['category'] = $question->getCategory();
            $data[$key]['content'] = $question->getContent();
        }

    

        return new Response (json_encode($data));
    }
}
