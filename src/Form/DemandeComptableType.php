<?php

namespace App\Form;

use App\Entity\DemandeComptable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeComptableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', TextType::class, [
                'label'=>'Objet de la demande'
            ])
            ->add('content', TextType::class, [
                'label'=>'Motif de la demande'
            ])
            ->add('hoursrequest', NumberType::class, [
                'label'=>'Heures de récupération demandées'
            ])
            ->add('holidaysrequest', NumberType::class, [
                'label'=>'Jours de congés demandés'
            ])
            ->add('hourssupp', NumberType::class, [
                'label'=>'Heures supplémentaires déclarées'
            ])
            ->add('money', NumberType::class, [
                'label'=>'Acompte demandé'
            ])
            /* ->add('createdat')
            ->add('user') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeComptable::class,
        ]);
    }
}
