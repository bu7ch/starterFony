<?php

namespace App\Form;

use Assert\NotBlank;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Webmozart\Assert\Assert as AssertAssert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', EmailType::class, [
        'label' => 'Email',
        'attr' => [
          'placeholder' => 'Entrez l\'email de l\'utilisateur',
        ],
        'constraints' => [
          new Assert\NotBlank([
            'message' => 'L\'email ne peut pas être vide.',
          ]),
          new Assert\Email([
            'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.',
          ]),
        ],
      ])
      ->add('password', PasswordType::class, [
        'label' => 'Mot de passe',
        'attr' => [
          'placeholder' => 'Entrez le mot de passe',
        ],
        'constraints' => [
          new Assert\NotBlank([
            'message' => 'Le mot de passe ne peut pas être vide.',
          ]),
          new Assert\Length([
            'min' => 6,
            'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
          ]),
        ],
      ])
      ->add('roles', ChoiceType::class, [
        'label' => 'Rôles',
        'choices' => [
          'Utilisateur' => 'ROLE_USER',
          'Administrateur' => 'ROLE_ADMIN',
        ],
        'expanded' => true,
        'multiple' => true,
      ]);
  }


  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Utilisateur::class,
    ]);
  }
}
