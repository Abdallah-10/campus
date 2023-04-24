<?php

namespace App\Form;

use App\Entity\User;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom et Prénom',
            ])
            ->add('email',EmailType::class,[
               
            ])
            ->add('roles',ChoiceType::class,[
                'label' =>"Role d'utilisateur",
                'choices' =>[
                    'ROLE_USER'=>'ROLE_USER',
                    'ROLE_ADMIN'=>'ROLE_ADMIN',
                ]
            ])
            ->add('password',PasswordType::class,[
                'required'=>false,
                'attr'=>[
                        'placeholder'=>'........'
                        ]
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
                'format' => 'yyyy-MM-dd',
				'required'=>false,
            ])
            ->add('phone',NumberType::class,[
                'label' => 'Téléphone',
                
            ])
            ->add('gouvernat',ChoiceType::class,[
                'label' =>'Gouvernorat',
                'placeholder' => 'Gouvernorat',
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
            ])
            ->add('ministere',ChoiceType::class,[
                'label' =>'Ministère',
                'placeholder' => 'Ministère',
				'required'=>false,
                'choices'=>[
                    'Ministère de la justice' => 'Ministère de la justice',
                    'Ministère de la Défense Nationale' => 'Ministère de la Défense Nationale',
                    'Ministère de l’intérieur' => 'Ministère de l’intérieur',
                    'Ministère des affaires étrangères, de la migration et des tunisiens à l’étranger' => 'Ministère des affaires étrangères, de la migration et des tunisiens à l’étranger',
                    'Ministère des finances' => 'Ministère des finances',
                    'Ministère de l’économie et de la planification' => 'Ministère de l’économie et de la planification',
                    'Ministère des Affaires Sociales' => 'Ministère des Affaires Sociales',
                    'Ministère de l’Industrie, des Mines et de l’Energie' => 'Ministère de l’Industrie, des Mines et de l’Energie',
                    'Ministère du Commerce et du Développement des Exportations' => 'Ministère du Commerce et du Développement des Exportations',
                    'Ministère de l’Agriculture, des Ressources Hydrauliques et de la Pêche Maritime' => 'Ministère de l’Agriculture, des Ressources Hydrauliques et de la Pêche Maritime',
                    'Ministère de la santé' => 'Ministère de la santé',
                    'Ministère de l’éducation' => 'Ministère de l’éducation',
                    'Ministère de l’enseignement supérieur et de la recherche scientifique' => 'Ministère de l’enseignement supérieur et de la recherche scientifique',
                    'Ministère de la Jeunesse et des Sports' => 'Ministère de la Jeunesse et des Sports',
                    'Ministère des Technologies de la Communication' => 'Ministère des Technologies de la Communication',
                    'Ministère des Transports' => 'Ministère des Transports',
                    'Ministère de l’Equipement et de l’Habitat' => 'Ministère de l’Equipement et de l’Habitat',
                    'Ministère des Domaines de l’Etat et des Affaires Foncières' => 'Ministère des Domaines de l’Etat et des Affaires Foncières',
                    'Ministère de l’Environnement' => 'Ministère de l’Environnement',
                    'Ministère du tourisme' => 'Ministère du tourisme',
                    'Ministère des Affaires Religieuses' => 'Ministère des Affaires Religieuses',
                    'Ministère de la Famille, de la Femme' => 'Ministère de la Famille, de la Femme',
                    'Ministère des affaires culturelles' => 'Ministère des affaires culturelles',
                    'Ministère de l’Emploi et de la Formation professionnelle' => 'Ministère de l’Emploi et de la Formation professionnelle',
                ],
            ])
            ->add('organisme',TextType::class,[
                'required'=>false,
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
            ])
            ->add('niveau',ChoiceType::class,[
                'label' =>'Niveau académique',
                'placeholder' => 'Niveau académique',
                'choices'=>[
                            'bac' => 'bac',
                            'Licence ou équivalent' => 'Licence ou équivalent',
                            'Master ou équivalent' => 'Master ou équivalent',
							'Ingénieur ou équivalent' => 'Ingénieur ou équivalent',
							'Doctorat ou équivalent' => 'Doctorat ou équivalent',
							'Autres'=>'Autres'
                        ],
            ])
            ->add('grade',ChoiceType::class,[
                'label' =>'Grade',
                'placeholder' => 'Grade',
                'choices'=>[
                            'Cadre' => 'Cadre',
                            'Exécution' => 'Exécution',
                            'Maîtrise' => 'Maîtrise',
                            
                        ],
            ])
            ->add('date_add',DateType::class,[
                'label' => "Date d'ajout",
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
			->add('identifiant',NumberType::class,[
                'label' => 'Identifiant unique',
                'required'=>true,
            ])
           ->get('roles')
           ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        // transform the array to a string
                        return count($rolesArray)? $rolesArray[0]: null;
                    },
                    function ($rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
            ))
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
