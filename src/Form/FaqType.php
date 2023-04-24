<?php

namespace App\Form;

use App\Entity\Faq;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('reponse',TextType::class)
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
            'data_class' => Faq::class,
        ]);
    }
}
