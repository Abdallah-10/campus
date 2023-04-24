<?php

namespace App\Form;

use App\Entity\Temoignage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TemoignageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom',TextType::class,[
                'label'=>'Prénom'
            ])
            ->add('poste')
            ->add('cover',FileType::class, [
                'required'   => false,
                'mapped'=>false,
                'label'=> 'Télécharger une image'
            ])
            ->add('comment',TextareaType::class,[
                'label' =>'Commentaire'
            ])
			->add('langue',ChoiceType::class,[
                'label' =>'langue',
                'placeholder' => 'langue',
                'choices'=>[
                            'arabe' => 'arabe',
                            'français' => 'français',
                        ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Temoignage::class,
        ]);
    }
}
