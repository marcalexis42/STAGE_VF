<?php

namespace App\Form;

use App\Entity\DemandeCSE;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeCSEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('object', TextType::class, [
                'label' => "Objet de la demande"
            ])
            ->add('content', TextType::class, [
                'label' => "Contenu de la demande"
            ])
            /* ->add('createdat', DateTimeType::class) */
            /* ->add('user') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DemandeCSE::class,
        ]);
    }
}
