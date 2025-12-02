<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Colis;
use App\Entity\Destinataire;
use App\Entity\Expedition;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'label' => 'Numéro du colis',
                'attr' => ['class' => 'form-control']
            ])
            ->add('poids', NumberType::class, [
                'label' => 'Poids',
                'attr' => ['class' => 'form-control']
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'attr' => ['class' => 'form-control']
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('expedition', EntityType::class, [
                'class' => Expedition::class,
                'choice_label' => function (Expedition $expedition) {
                    return $expedition->getType() . ' | ' . $expedition->getPortDepart() . ' -> ' . $expedition->getPortArrivee();
                },
                'choice_attr' => function (Expedition $expedition) {
                    return [
                        'data-type' => $expedition->getType(),
                    ];
                },
                'required' => false,
                'label' => 'Type Expédition',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Coût d\'expédition (FCFA)',
                'currency' => 'XOF',
                'required' => false,
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control'
                    ]
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => Colis::STATUT_EN_ATTENTE,
                    'En transit' => Colis::STATUT_TRANSIT,
                    'Arrivé' => Colis::STATUT_ARRIVE,
                    'Livré' => Colis::STATUT_LIVRE,
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image du colis',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('destinataire', EntityType::class, [
                'class' => Destinataire::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Colis::class,
        ]);
    }
}
