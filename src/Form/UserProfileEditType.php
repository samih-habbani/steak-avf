<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class UserProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            // ->add('profilePic') // later

            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'bg-warning text-light']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'bg-warning text-light']
            ])

            ->add('profilePic', FileType::class, [
                'label' => 'Photo de profil (fichier JPG, JPEG, PNG ou GIF, 1 Mo max):',
                'required' => false, // Allow empty uploads
                'mapped' => false,   // This field is not mapped to the entity property
                'constraints' => [
                    new File([
                        'maxSize' => '1024k', // Max file size (1MB)
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image JPG, JPEG, PNG ou GIF valide. 1 Mo max',
                    ]),
                ],
                'attr' => ['class' => 'bg-warning text-light']
            ]);
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
