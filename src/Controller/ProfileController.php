<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\UserProfileEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();

        // Fetch recent questions asked by the user
        $recentQuestions = $entityManager->getRepository(Question::class)->findBy(
            ['user' => $user],
            ['creationDate' => 'DESC'],
            3 // Limit to show
        );

        // Fetch recent answers given by the user
        $recentAnswers = $entityManager->getRepository(Answer::class)->findBy(
            ['user' => $user],
            ['creationDate' => 'DESC'],
            3 // Limit to show
        );


        return $this->render('profile/index.html.twig', [
            'recent_questions' => $recentQuestions,
            'recent_answers' => $recentAnswers,
        ]);
    }

    #[Route('/edit-profile', name: 'edit_profile')]
    public function editProfile(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();
    
        $form = $this->createForm(UserProfileEditType::class, $user);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a new profile picture was uploaded
            $profilePicFile = $form->get('profilePic')->getData();
    
            if ($profilePicFile) {
                // Generate a unique filename
                $newFilename = uniqid().'.'.$profilePicFile->guessExtension();
    
                // Move 
                try {
                    $profilePicFile->move(
                        $this->getParameter('profile_pic_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                    // ... TBD
                }
    
                // Update the user's profile picture
                $user->setProfilePic($newFilename);
            }
    
            // Save the updated user data to the database
            $entityManager->flush();
    
            // Redirect to profile page
            return $this->redirectToRoute('app_profile');
        }
    
        return $this->render('profile/edit_profile.html.twig', [
            'edit_profile_form' => $form->createView(),
        ]);
    }


    
}
