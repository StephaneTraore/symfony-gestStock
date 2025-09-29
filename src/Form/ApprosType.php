<?php

namespace App\Form;

use App\Entity\Appros;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApprosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('prix')
            ->add('dateAppros',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('nomFornisseur')
            ->add('nomProduit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appros::class,
        ]);
    }
}
