<?php

namespace App\Form;

use App\Entity\Newslatter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewslatterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('save',SubmitType::class,[
            'label' => 'save.label',
            'attr'=>[
                'class' =>'btn-newsletter'
            ]
            
        ])
            ->add('email',EmailType::class,[
                'label'=>false,
                'attr' =>[
                    'placeholder'=>'email.label'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Newslatter::class,
        ]);
    }
}
