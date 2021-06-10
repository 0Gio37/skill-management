<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Mission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewMissionUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', EntityType::class, [
                'class'=>Company::class,
                'choice_label'=>'nom',
                'label'=> ' ',
                'required'=>true
            ])
            ->add('descirptif', TextareaType::class, [
                'label'=> ' ',
                'attr'=>[
                    'style' => 'width:100%',
                    'rows' => 5
                ]
            ])
            ->add('debut', DateType::class, [
                'label'=> 'Début ',
                 'format'=>'dd MMMM yyyy',
                 'required'=>true
            ])
            ->add('fin', DateType::class, [
                'label'=> 'Fin ',
                'format'=>'dd MMMM yyyy',
                'required'=>true
            ])
            ->add('en_cours', ChoiceType::class, [
                'choices'=>[
                    'non'=>false,
                    'oui'=>true
                ],
                'label'=> 'En cours ',
                'required'=>true,
                'multiple'=>false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
