<?php

namespace App\Form;

use App\Entity\Formation;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
               $builder
            ->add('title',TextType::class,[
                'label'=>'Titre'
            ])
            ->add('cover',FileType::class, [
                'required'   => false,
                'mapped'=>false,
                'label'=> 'Télécharger une image'
            ])
            ->add('link',TextType::class,[
                'label' =>'Lien de la formation ',
                'attr' =>[
                    'placeholder'=>''
                ]
            ])
            ->add('duration',NumberType::class,[
                'label' =>'Durée de la formation en (H)',
                'attr' =>[
                    'placeholder'=>'30'
                ]
            ])
            ->add('langue',TextType::class,[
                'attr' =>[
                    'placeholder'=>'Exp : français'
                ]
            ])
            ->add('location',TextType::class,[
                'label'=>'Local',
                'attr' =>[
                    'placeholder'=>'Exp : International'
                ]
            ])
            ->add('thematique',TextType::class,[
				'label'=>'Thématique',
                'attr' =>[
                    'placeholder'=>'Exp : Big Data'
                ]
            ])
            ->add('partenaire',TextType::class,[
				'label'=>'Partenaire',
                'attr' =>[
                    'placeholder'=>'Exp : ITU'
                ]
            ])
            ->add('date_ins_d',DateType::class,[
                'label' => "Date début de l'inscription",
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_ins_f',DateType::class,[
                'label' => "Date fin de l'inscription",
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_start',DateType::class,[
                'label' => 'Date début de la formation',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_end',DateType::class,[
                'label' => 'Date fin de la formation',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('type',TextType::class,[
                'attr' =>[
                    'placeholder'=>'Exp : En ligne'
                ]
            ])
            ->add('apercu')
            ->add('objectifs')
            ->add('certifs')
            ->add('structure')
            ->add('criteres',TextType::class,[
			     'label'=>'Critères'
			])
            ->add('partenaire',ChoiceType::class,[
                'choices'=>[
                    'ITU' => 'ITU',
                    'GSMA' => 'GSMA',
                    'Autre' => 'Autre',
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
