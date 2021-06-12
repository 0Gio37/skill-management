<?php

namespace App\Form;

use App\Entity\Expertise;
use App\Entity\SearchBySkillLevel;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchBySkillLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('niveau', EntityType::class,[
                'class'=> Expertise::class,
                'choice_label'=>'niveau',
                'label'=>'Niveau : ',
                'attr'=>[
                    'style' => 'width:50%',
                ]
            ])
            ->add('nom',EntityType::class, [
                'class'=>Skill::class,
                'choice_label'=>'nom',
                'label'=> 'Compétences',
                'attr'=>[
                    'style' => 'width:50%',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchBySkillLevel::class,
        ]);
    }
}
