<?php

namespace App\Form;

use App\Entity\Calendriers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CalendriersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
                  ->add('title' , TextType::class, array('label' => 'Titre' ))
                  ->add('start', DateTimeType::class, [
                      'date_widget' => 'single_text',
                      'label' => 'Début de l évènement'
                  ]
               )
                  ->add('end', DateTimeType::class, [
                      'date_widget' => 'single_text',
                      'label' => 'Fin de l évènement'
                  ])
                  ->add('description')
                  ->add('espace', ChoiceType::class, [
                    'choices' => [
                    'Commun' => 'Commun',
                    'Administration'   => 'Administration',
                    'Maintenance' => 'Maintenance',
                    'Veilleur'   => 'Veilleur',
                    'Entretien' => 'Entretien'
                  ]])
                  ->add('all_day' , CheckboxType::class , array('label' => 'Journée complète', 'required' => false))

              ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendriers::class,
        ]);
    }
}
