<?php

namespace App\Form;

use App\Entity\Fournisseurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomFournisseur')
            ->add('prenomFournisseur')
            ->add('adresseFournisseur')
            ->add('telephoneFournisseur')
            ->add('emailFournisseur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseurs::class,
        ]);
    }
}
