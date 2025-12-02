<?php

namespace App\Form;

use App\Entity\Expedition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ExpeditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'label' => 'Numéro d\'expédition',
                'attr' => ['class' => 'form-control']
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Maritime' => Expedition::TYPE_MARITIME,
                    'Aérien' => Expedition::TYPE_AERIEN,
                ],
                'placeholder' => 'Sélectionner le type de transport',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateDepart', DateTimeType::class, [
                'label' => 'Date de départ',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateArriveePrevue', DateTimeType::class, [
                'label' => 'Date d\'arrivée prévue',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateArriveeReelle', DateTimeType::class, [
                'label' => 'Date d\'arrivée réelle',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('portDepart', TextType::class, [
                'label' => 'Port de départ',
                'attr' => ['class' => 'form-control']
            ])
            ->add('portArrivee', TextType::class, [
                'label' => 'Port d\'arrivée',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expedition::class,
        ]);
    }
}
