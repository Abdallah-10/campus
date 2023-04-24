<?php

namespace App\Form;

use App\Entity\Domaines;
use App\Entity\Ministere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomainesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom du domaine Email'
            ])
            ->add('categorie',TextType::class,[
                'label'=>'Eُtablissements en français'
            ])
            ->add('categorieAr',TextType::class,[
                'label'=>'Eُtablissements en arabe'
            ])
            ->add('ministere',EntityType::class,[
                'class' => Ministere::class,
                'choice_label' => 'name'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Domaines::class,
        ]);
    }
}
