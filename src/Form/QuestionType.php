<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Sujet',
                'attr' => ['class' => 'bg-warning text-light']
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Décrivez votre question',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

            ->add('code', TextareaType::class,[
                'label' => 'Code (si nécessaire)',
                'attr' => ['class' => 'bg-warning text-light', 'rows' => '3']
            ])

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
            // ->add('creationDate', DateType::class)
            // ->add('viewCount')
            // ->add('likeCount')
            // ->add('isClosed')
            // ->add('closedDate')
            ->add('category', EntityType::class, [
                'placeholder' => '--',
                'label' => 'Catégorie',
                'class' => Category::class,
                'attr' => ['class' => 'bg-warning text-light']
            ])
            // ->add('User')
            ->add('save', SubmitType::class, [
                'label' => 'Poser',
                'attr' => ['class' => 'btn btn-primary text-light']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
