<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('image', FileType::class, [
                'required'   => false,
                'mapped'=>false,
                'label'=> 'Télécharger une image'
            ])
            ->add('date')
			->add('location')
            ->add('langue',ChoiceType::class,[
                'label' =>'langue',
                'placeholder' => 'langue',
                'choices'=>[
                            'arabe' => 'arabe',
                            'français' => 'français',
                        ],
            ])
			->add('type',ChoiceType::class,[
                'label' =>'type',
                'placeholder' => 'type',
                'choices'=>[
                            'actualité' => 'actualité',
                            'événement' => 'événement',
                        ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
