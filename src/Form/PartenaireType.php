<?php

namespace App\Form;

use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
         ->add('titre')
            ->add('cover',FileType::class, [
                'mapped'=>false,
                'label'=> 'upload image'
            ])
            ->add('link',TextType::class,[
                'required'   => false,
                'attr'=>[
                    'placeholder'=>'lien vers le site web du partenaire'
                ]
            ])
            ->add('category',ChoiceType::class,[
                'placeholder' => 'Category',
                'choices'=>[
                            'Initié par' => 'initie',
                            'Financé par' => 'finance',
                            'Implémenté par' => 'implimente',
                        ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partenaire::class,
        ]);
    }
}
