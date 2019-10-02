<?php

namespace App\Form;

use App\Entity\Expediteur;
use App\Entity\Beneficiaire;
use App\Entity\User;
use App\Entity\Transactions;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('montant')
            ->add('comenvoi')
            ->add('comretrait')
            ->add('cometat')
            ->add('comsystem')
            ->add('frais')
            ->add('type')
            ->add('cni')
            ->add('expediteur', EntityType::class,[
                'class'=> Expediteur::class,
                'choice_label'=> 'expediteur_id'
            ])
            ->add('beneficiaire',EntityType::class,[
                'class' => Beneficiaire::class,
                'choice_label'=>'beneficiaire_id'
            ])
            ->add('user',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'user_id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transactions::class,
        ]);
    }
}
