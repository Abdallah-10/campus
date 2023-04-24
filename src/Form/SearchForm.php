<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function __construct(FormationRepository $formRepository)
    {
        $this->formRepository = $formRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', ChoiceType::class,[
            
            'label' =>false,
            'choices' => $this->choices(),
            'required'=> false,
            
        ])    
        ->add('thematique', ChoiceType::class,[
            'label' =>false,
            'choices' => $this->choicest(),
            'required'=> false,
        ])    
        ->add('langue', ChoiceType::class,[
            'label' =>false,
            'choices' => $this->choicesl(),
            'required'=> false,
        ])    
        
        ->add('q',TextType::class,[
                'label' =>false,
                'required'=> false,
                'attr' => [
                    'placeholder' => 'Entrer mots clés'
                ]
            ])
        ->add('Rechercher', SubmitType::class)
        ;
          
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> SearchData::class,
            'method'=>'GET',
            'csrf_protection' => false
        ]);
    }
    public function choices()
    {
       $data=[];
       $arr = ['Type de formation'=>''];
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
       $arr = ['Thématiques'=>''];
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
       $arr = ['Langue'=>''];
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