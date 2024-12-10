<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use App\Entity\Contribution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ContributionType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('montant')
      ->add('date', DateTimeType::class, [
        'widget' => 'single_text',
        'html5' => false,
        'attr' => ['class' => 'ui calendar date-input'],
      ])
      ->add('utilisateur', EntityType::class, [
        'class' => Utilisateur::class,
        'choice_label' => 'email',
      ])
      ->add('projet', EntityType::class, [
        'class' => Projet::class,
        'choice_label' => 'titre',
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Contribution::class,
    ]);
  }
}
