<?php

namespace App\Form;

use App\Entity\Port;
use App\Entity\TarifPort;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifPortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeTransport', ChoiceType::class, [
                'label' => 'Type de transport',
                'choices' => [
                    'MARITIME' => TarifPort::TYPE_MARITIME,
                    'AÉRIEN' => TarifPort::TYPE_AERIEN,
                ],
                'placeholder' => 'Entrez le type de transport',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('portDepart', EntityType::class, [
                'class' => Port::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez le port de départ',
                'attr' => ['class' => 'form-control']
            ])
            ->add('portArrivee', EntityType::class, [
                'class' => Port::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez le port d\'arrivée',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prixKg', MoneyType::class, [
                'label' => 'Prix par kg',
                'currency' => 'XOF',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TarifPort::class,
        ]);
    }
}
