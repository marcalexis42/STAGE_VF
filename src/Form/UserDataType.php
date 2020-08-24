<?php

namespace App\Form;

use App\Entity\UserData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poste',ChoiceType::class, [
            'choices' => [
            'Direction'   => 'Direction',
            'Maintenance' => 'Maintenance',
            'Entretien'   => 'Entretien',
            'Veilleur' => 'Veilleur',
            'Secrétariat'   => 'Secrétariat',
            'Comptable'   => 'Comptable'
            ]])
            
            ->add('delegate', CheckboxType::class, [
                'label' => 'Délégué CSE'
            ])
            
            ->add('adress', TextType::class, [
                'label' => 'Adresse postale'
            ])
            
            ->add('phonenumber', TextType::class, [
                'label' => "Numéro de téléphone"
            ])
            
            ->add('birthday', BirthdayType::class, [
                'label' => "Date d'anniversaire"
            ])
            
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserData::class,
        ]);
    }
}
