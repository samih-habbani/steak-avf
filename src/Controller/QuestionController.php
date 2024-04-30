<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Category;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/questions', name: 'app_questions')]
    public function showQuestions(EntityManagerInterface $entityManager, QuestionRepository $questionRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $selectedCategoryId = $request->query->getInt('category_id');
        $questions = [];
    
        if ($selectedCategoryId) {
            // Fetch questions based on the selected category
            $questions = $questionRepository->findByCategory($selectedCategoryId);
        } else {
            // Fetch all questions
            $questions = $entityManager->getRepository(Question::class)->findBy([], ['creationDate' => 'DESC']);
        }

        // Extract unique category IDs from questions
        $categoryIds = [];
        foreach ($questions as $question) {
            $categoryId = $question->getCategory()->getId();
                if (!in_array($categoryId, $categoryIds)) {
                    $categoryIds[] = $categoryId;
                }
        }

        // Paginate questions
        $paginationQuesions = $paginator->paginate(
            $questions,
            $request->query->getInt('page', 1), // Current page number, default to 1 if not provided in the query string
            5 // Number of items per page
        );

        // Fetch categories based on the unique category IDs from questions
        $categoriesWithQuestions = $entityManager->getRepository(Category::class)->findBy(['id' => $categoryIds]);


        if ($request->isXmlHttpRequest()) {
            return $this->render('questions/_question_list.html.twig', [
                'questions' => $questions,
                'paginationQuestions' => $paginationQuesions
            ]);
        }

        
        return $this->render('questions/all.html.twig', [
            // 'categories' => $categories,
            'categories' => $categoriesWithQuestions,
            'questions' => $questions,
            'paginationQuestions' => $paginationQuesions
        ]);
    }

    #[Route('/newQuestion', name: 'new_question')]
    public function newQuestion(Request $request, QuestionRepository $questionRepository, EntityManagerInterface $entityManager): Response
    {

        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            // Retrieve the authenticated user
             $user = $this->getUser();

            // Set the user to the question entity
            $newQuestion->setUser($user);
            $newQuestion->setCreationDate(new \DateTime);
    
            $questionRepository->save($newQuestion, true);

            $this->addFlash(
                'notice',
                'Thank you for your question!'
            );

            return $this->redirectToRoute('app_home');
        }


        return $this->render('questions/new.html.twig', [
            'new_question_form' => $form->createView(),
            'image' => $newQuestion
        ]);
    }


    // ROUTE FOR QUESTION TO OPEN QUESTION BY ID ON CLICK


    #[Route('/question/{id}', name: 'app_question', requirements: ['id' => '\d+'], methods : ['GET', 'POST'])]
    public function showQuestion(EntityManagerInterface $entityManager, $id, Request $request): Response
    {
    
        $question = $entityManager->getRepository(Question::class)->findBy(['id' => $id]);
        $questionId = $entityManager->getRepository(Question::class)->find(['id' => $id]); // to properly send Id to answer form


        // answer
        $answer = new Answer();
        $answerForm = $this->createForm(AnswerType::class, $answer);
        $answerForm->handleRequest($request);





        // Increment the view count
        $viewCount = $questionId->getViewCount() ?? 0;
        $questionId->setViewCount($viewCount + 1);

        $entityManager->persist($questionId);
        $entityManager->flush();
        
        // answer
        if ($answerForm->isSubmitted() && $answerForm->isValid()) {

            $answer->setQuestion($questionId);
            $answer->setCreationDate(new \DateTime);
            $answer->setUser($this->getUser());
            $answer->setIsAccepted(false);

            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Your asnwer is submitted'
            );

        }




        $findQuestion = $entityManager->getRepository(Question::class)->find(['id' => $id]); // to use getCategory()

        $relatedQuestions = $entityManager->getRepository(Question::class)->findRelatedQuestion($findQuestion->getCategory(), $id);

        $answers = $entityManager->getRepository(Answer::class)->findAnswers($id);
 
        
        // Get categories with associated questions
        $categoriesWithQuestions = $entityManager->getRepository(Category::class)->findCategoriesWithQuestions();

        
        return $this->render('questions/index.html.twig', [
            'answer_form' => $answerForm,
            'question' => $question,
            'relatedQuestions' => $relatedQuestions,
            'answers' => $answers,
            'categoriesWithQuestions' => $categoriesWithQuestions,
            'category' => $findQuestion->getCategory() // Pass the 'category'
        ]);
    }

    
    #[Route('/question/{id}/like', name: 'like_question_ajax', methods: ['POST'])]
    public function likeQuestionAjax($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Retrieve the question entity by the ID
        $question = $entityManager->getRepository(Question::class)->find($id);

        // Increment the like count
        $likeCount = $question->getLikeCount() ?? 0;
        $question->setLikeCount($likeCount + 1);

        $entityManager->persist($question);
        $entityManager->flush();

        // Return the updated like count in JSON format
        return new JsonResponse(['likeCount' => $question->getLikeCount()]);
    }

    #[Route('/question/{id}/dislike', name: 'dislike_question_ajax', methods: ['POST'])]
    public function dislikeQuestionAjax($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Retrieve the question entity by the ID
        $question = $entityManager->getRepository(Question::class)->find($id);

        // Decrement the like count (or perform any logic for disliking)

        $likeCount = $question->getLikeCount() ?? 0;
        $question->setLikeCount($likeCount - 1);

        $entityManager->persist($question);
        $entityManager->flush();

        // Return the updated like count in JSON format
        return new JsonResponse(['likeCount' => $question->getLikeCount()]);
    }



    #[Route('/question/{id}/likeAnsw', name: 'like_answer_ajax', methods: ['POST'])]
    public function likeAnswerAjax($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Retrieve the answer entity by the ID
        $answer = $entityManager->getRepository(Answer::class)->find($id);

        // Increment the like count
        $likeCountAnsw = $answer->getLikeCount() ?? 0;
        $answer->setLikeCount($likeCountAnsw + 1);

        $entityManager->persist($answer);
        $entityManager->flush();

        // Return the updated like count in JSON format
        return new JsonResponse(['likeCountAnsw' => $answer->getLikeCount()]);
    }

    #[Route('/question/{id}/dislikeAnsw', name: 'dislike_answer_ajax', methods: ['POST'])]
    public function dislikeAnswerAjax($id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Retrieve the answer entity by the ID
        $answer = $entityManager->getRepository(Answer::class)->find($id);

        // Decrement the like count (or perform any logic for disliking)

        $likeCountAnsw = $answer->getLikeCount() ?? 0;
        $answer->setLikeCount($likeCountAnsw - 1);

        $entityManager->persist($answer);
        $entityManager->flush();

        // Return the updated like count in JSON format
        return new JsonResponse(['likeCountAnsw' => $answer->getLikeCount()]);
    }
}
