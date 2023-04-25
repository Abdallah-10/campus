<?php

namespace App\Form;

use App\Data\SearchAdvance;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchAvanceType extends AbstractType
{
    private $formRepository;
    
    public function __construct(FormationRepository $formRepository)
    {
        $this->formRepository = $formRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('q',TypeTextType::class,[
            'label' =>false,
            'required'=> false,
            'attr' => [
                'placeholder' => 'Entrer mots clés'
            ]
        ])
        ->add('type', ChoiceType::class,[
            'multiple' => true,
            'expanded' => true,
            'label' => 'Modalité',
            'choices' => $this->choices(),
            'required'=> false,
        ])    
        ->add('thematique', ChoiceType::class,[
            'multiple' => true,
            'expanded' => true,
            'label' => 'Thématiques',
            'choices' => $this->choicest(),
            'required'=> false,
        ])    
        ->add('langue', ChoiceType::class,[
            'multiple' => true,
            'expanded' => true,
            'label' => 'Langues',
            'choices' => $this->choicesl(),
            'required'=> false,
        ])  
        ->add('partenaire', ChoiceType::class,[
            'multiple' => true,
            'expanded' => true,
            'label' =>'Partenaires',
            'choices'=>[
                'ITU' => 'ITU',
                'GSMA' => 'GSMA',
            ],
            'required'=> false,
        ]) 
        ->add('date_ins_d',ChoiceType::class,[
            'label' => "Début de l'inscription",
            'choices' => [
                'Tous' => 'Tous',
                'En cours' => 'En cours',
            ],
            'expanded' => true,
            'multiple' => false,
        ])
      
        ->add('date_start',DateType::class,[
            'required'=> false,
            'label' => 'Date début de la formation',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ])
        ->add('date_end',DateType::class,[
            'required'=> false,
            'label' => 'Date fin de la formation',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ])
        
       
        ->add('Rechercher', SubmitType::class)
        ;
          
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> SearchAdvance::class,
            'method'=>'GET',
            'csrf_protection' => false
        ]);
    }
    public function choices()
    {
       $data=[];
       $arr = [];
       $types = $this->formRepository->findDistinctType();
       foreach($types as $key=>$type){
        if(!empty($type['type'])){
            array_push($data,$type['type']);
        }
       }
       foreach($data as $key=>$value){
       
        $arr += [$value=>$value];
       }
       return $arr;
    }
    public function choicest()
    {
       $data=[];
       $arr = [];
       $types = $this->formRepository->findDistinctThematique();
       foreach($types as $key=>$type){
         if(!empty($type['thematique'])){
            array_push($data,$type['thematique']);
         }
       }
       foreach($data as $key=>$value){
       
        $arr += [$value=>$value];
       }
       return $arr;
    }
    public function choicesl()
    {
       $data=[];
       $arr = [];
       $types = $this->formRepository->findDistinctLangue();
       foreach($types as $key=>$type){
        if(!empty($type['langue'])){
            array_push($data,$type['langue']);
        }
       }
       foreach($data as $key=>$value){
       
        $arr += [$value=>$value];
       }
       return $arr;
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
