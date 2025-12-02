<?php

namespace App\Form;

use App\Entity\Colis;
use App\Entity\HistoriqueColis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HistoriqueColisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('colis', EntityType::class, [
                'class' => Colis::class,
                'choice_label' => 'numero',
                'label' => 'Colis',
                'placeholder' => 'Sélectionner un colis',
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En attente' => Colis::STATUT_EN_ATTENTE,
                    'En transit' => Colis::STATUT_TRANSIT,
                    'Arrivé' => Colis::STATUT_ARRIVE,
                    'Livré' => Colis::STATUT_LIVRE,
                ],
                'label' => 'Statut',
                'placeholder' => 'Sélectionner un statut',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueColis::class,
        ]);
    }
}
