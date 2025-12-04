<?php

namespace App\Form;

use App\Entity\Colis;
use App\Entity\Expedition;
use App\Entity\Port;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'disabled' => true,
                'required' => false,
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
            ->add('colis', EntityType::class, [
                'class' => Colis::class,
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
                'choice_label' => function (Colis $colis) {
                    return $colis->getNumero() . ' - ' . $colis->getType() . ' (' . $colis->getPoids() . ' kg)';
                },
                'label' => 'Colis associés',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Coût de l\'expédition',
                'required' => false,
                'attr' => ['class' => 'form-control', 'step' => '0.01']
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
            ->add('portDepart', EntityType::class, [
                'class' => Port::class,
                'choice_label' => 'nom',
                'label' => 'Port de départ',
                'placeholder' => 'Sélectionner un port de départ',
                'attr' => ['class' => 'form-control']
            ])
            ->add('portArrivee', EntityType::class, [
                'class' => Port::class,
                'choice_label' => 'nom',
                'label' => 'Port d\'arrivée',
                'placeholder' => 'Sélectionner un port d\'arrivée',
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
