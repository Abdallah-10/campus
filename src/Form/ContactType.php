<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder'=>'Nom'
                ]
            ])
            ->add('lastname',TextType::class,[
                
                'attr' => [
                    'placeholder'=>'Prénom'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr' => [
                    'placeholder'=>'Email'
                ]
            ])
            ->add('phone',NumberType::class,[
                'required'=>false,
                'attr' => [
                    'placeholder'=>'Téléphone',
                    'required' => false
                ]
            ])
			 ->add('type',ChoiceType::class,[
                'choices'=>[
                    "type d'assistance"=>"type d'assistance",
                    'Assistance technique' => 'Assistance technique',
                    'Réclamations' => 'Réclamations',
                    'Bug informatique'=>'Bug informatique',
                    'Autre' => 'Autre',
                ],
                'required' => true
            ])
            ->add('object',TextType::class,[
                'required'=>false,
                'attr' => [
                    'placeholder'=>'Objet'
                ]
            ])
            ->add('comment',TextareaType::class,[
                
                'attr' => [
                    'placeholder'=>'Votre message'
                ]
            ])
            ->add('dateAdd',HiddenType::class,[
                'data' =>date('Y-m-d'),
            ])
			->add('recaptcha', Recaptcha3Type::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
