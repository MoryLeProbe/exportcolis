<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', MoneyType::class, [
                'label' => 'Montant (F CFA)',
                'currency' => 'XOF',
                'attr' => ['class' => 'form-control']
            ])
            ->add('mode', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'Espèce' => Paiement::MODE_CASH,
                    'Mobile Money' => Paiement::MODE_MOBILE_MONEY,
                    'Virement' => Paiement::MODE_VIREMENT,
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Payé' => Paiement::STATUT_PAYE,
                    'Partiel' => Paiement::STATUT_PARTIEL,
                    'Impayé' => Paiement::STATUT_IMPAYE,
                ],
                'attr' => ['class' => 'form-control']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
