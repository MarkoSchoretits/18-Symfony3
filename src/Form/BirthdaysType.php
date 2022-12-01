<?php

namespace App\Form;

use App\Entity\Anniversary;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class BirthdaysType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder
          ->add('name', TextType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px']
          ])
          ->add('date', DateType::class, [
              'attr' => ['style' => 'margin-bottom:15px']
          ])
          ->add('type', TextType::class, [
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px']
          ])
          ->add('type', ChoiceType::class, [
              'choices' => ['GEB' => 'GEB', 'NAM' => 'NAM', 'STB' => 'STB', 'BEG' => 'BEG'],
              'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px']
          ])
          ->add('details', TextType::class, [
            'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px']
          ])
          ->add('save', SubmitType::class, [
            'label' => 'Submit Data',
            'attr' => ['class' => 'btn-primary', 'style' => 'margin-bottom:15px']
        ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => Anniversary::class,
      ]);
  }
}