<?php

namespace App\Form;

use App\Entity\Ventes;
use Doctrine\DBAL\Types\DateType as TypesDateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nomProduit')
            ->add('nomClient')
            ->add('quantite')
            ->add('prix')
            ->add('dateVente',DateType::class,[
                'widget'=>'single_text'
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ventes::class,
        ]);
    }
}
