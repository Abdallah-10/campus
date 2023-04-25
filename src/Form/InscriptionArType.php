<?php

namespace App\Form;

use App\Entity\Domaines;
use App\Entity\Inscription;
use App\Entity\Ministere;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionArType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,[
            'label' => 'الأسم',
        ])
		->add('lastname',TextType::class,[
            'label' => 'اللقب',
        ])
        ->add('email',EmailType::class,[
            'disabled'   => true,
        ])
        ->add('organisme',EntityType::class, [
            'label' =>' المنشأة أو المؤسسة العمومية',
            'class' => Domaines::class,
            'choice_label' => 'categorieAr',
            'required'=>true,
            ])
        ->add('genre',ChoiceType::class,[
            'label' =>'Genre',
            'placeholder' => 'Genre',
            'choices'=>[
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                    ],
        ])
        ->add('age',DateType::class,[
            'label' =>'Date de naissance',
            'widget' => 'single_text',
            'required'=>true,
        ])
        ->add('phone',NumberType::class,[
            'label' => 'Téléphone portable',
            'required'=>true,
        ])
        ->add('identifiant',NumberType::class,[
            'label' => 'Identifiant unique (CNSS/CNRPS)',
            'required'=>true,
        ])
        ->add('gouvernorat',ChoiceType::class,[
            'label' =>'Gouvernorat de travail',
            'placeholder' => 'Gouvernorat de travail',
            'choices'=>[
                        'Ariana' => 'Ariana',
                        'Béja' => 'Béja',
                        'Ben Arous' => 'Ben Arous',
                        'Bizerte' => 'Bizerte',
                        'Gabès' => 'Gabès',
                        'Gafsa' => 'Gafsa',
                        'Jendouba' => 'Jendouba',
                        'Kairouan' => 'Kairouan',
                        'Kasserine' => 'Kasserine',
                        'Kébili' => 'Kébili',
                        'ElKef' => 'ElKef',
                        'Mahdia' => 'Mahdia',
                        'Manouba' => 'Manouba',
                        'Médenine' => 'Médenine',
                        'Monastir' => 'Monastir',
                        'Nabeul' => 'Nabeul',
                        'Sfax' => 'Sfax',
                        'Sidi Bouzid' => 'Sidi Bouzid',
                        'Siliana' => 'Siliana',
                        'Sousse' => 'Sousse',
                        'Tataouine' => 'Tataouine',
                        'Tozeur' => 'Tozeur',
                        'Tunis' => 'Tunis',
                        'Zaghouan' => 'Zaghouan',
                    ],
                    'required'=>true,
        ])
        ->add('ministere',EntityType::class, [
                'class' => Ministere::class,
                'label' => 'Ministère',
                'choice_label' => 'nameAr',
                'required'=>true,
        ])
        
         ->add('poste',ChoiceType::class,[
            'label' =>'Niveau de responsabilité',
            'placeholder' => 'Niveau de responsabilité',
            'choices'=>[
                        'Directeur Général, Directeur Central...' => ' Directeur Général, Directeur Central...',
                        'Directeur ou équivalent' => 'Directeur ou équivalent',
                        'Sous-Directeur ou équivalent' => 'Sous-Directeur ou équivalent',
                        'Chef service ou équivalent' => 'Chef service ou équivalent',
                        'Sans fonction' => 'Sans fonction',							
                    ],
            'required'=>true,
        ])
        ->add('niveau',ChoiceType::class,[
            'label' =>'Niveau académique',
            'placeholder' => 'Niveau académique',
            'choices'=>[
                        'Bac' => 'Bac',
                        'Licence ou équivalent' => 'Licence ou équivalent',
                        'Master ou équivalent' => 'Master ou équivalent',
                        'Ingénieur ou équivalent' => 'Ingénieur ou équivalent',
                        'Doctorat ou équivalent' => 'Doctorat ou équivalent',
                        'Autres'=>'Autres'
                    ],
            'required'=>true,
        ])
        ->add('grade',ChoiceType::class,[
            'label' =>'Grade',
            'required'=>true,
            'placeholder' => 'Grade',
            'choices'=>[
                        'Cadre' => 'Cadre',
                        'Exécution' => 'Exécution',
                        'Maîtrise' => 'Maîtrise',
                        
                    ],
        ])
       
        
        ->add('recaptcha', Recaptcha3Type::class)
       
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
