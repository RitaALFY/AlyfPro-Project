<?php

namespace App\Form;

use App\Entity\Speciality;
use App\Entity\User;
use App\Repository\SpecialityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    private $specialityRepository;
    public function __construct(SpecialityRepository $specialityRepository)
    {
        $this->specialityRepository = $specialityRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lastName',null, [
                'label' => 'Nom',
            ])
            ->add('firstName',null, [
                'label' => 'Prénom',
            ])
            ->add('email', EmailType::class, [
        'label' => 'Email'
//        'constraints' => [
//            new Assert\NotBlank([
//                'message' => 'L\'adresse e-mail est requise.',
//            ]),
//            new Assert\Email([
//                'message' => 'L\'adresse e-mail n\'est pas valide.',
//            ]),
//        ],
    ])
//            ->add('roles', RolesType::class, [
//                'label' => 'Role',
//                ])
            ->add('password',PasswordType::class, [
        'label' => 'Mot de passe'
    ])
            ->add('image', FileType::class,[
                'label' => 'image',
                'required' => false,
                'mapped' => false, // => Dit à Symfony : t'inquiètes, je le gère moi-même
                'constraints' => [
                    new File(
                        maxSize: '3M',
                        mimeTypes: ['image/png', 'image/jpeg'],
                        maxSizeMessage: 'Votre fichier est trop lourd !',
                        mimeTypesMessage: 'Déposer seulement un .jpg ou .png'
                    )
                ]
            ])


        ->add('specialities', EntityType::class, [
        'label' => 'Specialities',
        'class' => Speciality::class,
        'choice_label' => 'title',
                'multiple' => true,
//                'expanded' => true,
                'required' => false,
        'query_builder' => function (SpecialityRepository $sp) {
            return $sp->createQueryBuilder('s')
                ->orderBy('s.title', 'ASC');
        }
    ])
    ;
//     ->add('specialities', TextType::class, [
//         'label' => 'Nouvelle Spécialité',
//         'required' => false,
//     ]);
    }





    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

//    private function getSpecialities()
//    {
//        $existingSpecialities = $this->specialityRepository->findAll();
//
//        $choices = [];
//        foreach ($existingSpecialities as $speciality) {
//            $choices[$speciality->getTitle()] = $speciality->getId();
//        }
//
//        return $choices;
//    }

}
