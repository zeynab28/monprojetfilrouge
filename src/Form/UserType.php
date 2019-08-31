<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Compte;

use App\Entity\Prestataire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('tel')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('cni')
            ->add('statut')
            //->add('partenaire')
            ->add('email')
            ->add("imageFile", VichImageType:: class)
            ->add('partenaire', EntityType::class,[
                'class'=> Prestataire::class,
                'choice_label'=> 'partenaire_id'
            ])
            ->add('compte', EntityType::class,[
                'class'=> Compte::class,
                'choice_label'=> 'compte_id'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false
        ]);
    }
}
