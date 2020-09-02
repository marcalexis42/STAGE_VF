<?php

namespace App\Form;

use App\Entity\UserData;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class CompteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            /* ->add('users')
            ->add('poste',ChoiceType::class, [
            'choices' => [
            'Direction'   => 'Direction',
            'Maintenance' => 'Maintenance',
            'Entretien'   => 'Entretien',
            'Veilleur' => 'Veilleur',
            'Secrétariat'   => 'Secrétariat',
            'Comptable'   => 'Comptable'
            ]])
            
            ->add('delegate', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
            ],
                 'label' => 'Délégué CSE ?',
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adresse postale'
            ])
            
            ->add('phonenumber', TextType::class, [
                'label' => "Numéro de téléphone"
            ])
            
            ->add('birthday', BirthdayType::class, [
                'label' => "Date d'anniversaire"
            ]) */
            ->add('hours', NumberType::class, [
                'label' => "Compteur d'heures"
            ])
            ->add('holidays', NumberType::class, [
                'label' => "Compteur de congés"
            ])
        ;
    }
}

