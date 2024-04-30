<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => ['class' => 'bg-warning text-light']
            ])
            ->add('code', TextareaType::class,[
                'label' => 'Code (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '4']
            ])
            // ->add('creationDate')
            // ->add('isAccepted')
            // ->add('likeCount')
            // ->add('question')
            // ->add('user')
            ->add('contentTwo', TextareaType::class,[
                'label' => 'Description (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('codeTwo', TextareaType::class,[
                'label' => 'Code (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('contentThree', TextareaType::class,[
                'label' => 'Description (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('codeThree', TextareaType::class,[
                'label' => 'Code (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('contentFour', TextareaType::class,[
                'label' => 'Description (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('codeFour', TextareaType::class,[
                'label' => 'Code (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => ['class' => 'btn btn-primary text-light']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
