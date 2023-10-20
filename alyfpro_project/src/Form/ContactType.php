<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomComplet', TextType::class,[
                'label' => 'Nom Complet',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le nom complet est requis.',
                    ]),
                ],
            ])
            ->add('Objet', TextType::class,[
                'label' => 'Objet',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'objet est requis.',
                    ]),
                ],
            ])
            ->add('Email', EmailType::class, [
                'label' => 'Votre Email',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'adresse e-mail est requise.',
                    ]),
                    new Assert\Email([
                        'message' => 'L\'adresse e-mail n\'est pas valide.',
                    ]),
                ],
            ])
            ->add('VotreMessage', TextareaType::class, [
                'label' => 'Votre message',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le message est requis.',
                    ]),
                ],
            ])
            ->add('captcha', ReCaptchaType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
