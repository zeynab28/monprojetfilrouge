<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('solde')
            ->add('partenaire', EntityType::class,[
                'class'=> Prestataire::class,
                'choice_label'=> 'partenaire_id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
