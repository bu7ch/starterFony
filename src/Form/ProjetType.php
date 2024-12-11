<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
          'attr' => ['class' => 'ui input']
      ])
      ->add('description', TextareaType::class, [
          'attr' => ['class' => 'ui textarea']
      ])
      ->add('montantObjectif', MoneyType::class, [
          'currency' => 'EUR',
          'attr' => ['class' => 'ui input']
      ])
      ->add('dateLimite', DateTimeType::class, [
          'widget' => 'single_text', 
        'html5' => false,          
        'attr' => ['class' => 'ui calendar date-input'], 
      ])
      ->add('statut')
      ->add('createur', EntityType::class, [
          'class' => Utilisateur::class,
          'choice_label' => 'email',
      ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
