<?php

namespace App\Form;

use App\Entity\Expertise;
use App\Entity\LienUserSkill;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewSkillUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prefer', ChoiceType::class,[
                'choices'=>[
                    'oui'=> true,
                    'non'=> false
                    ],
                'label'=> ' ',
                'required'=>true
                ])
            ->add('skill', EntityType::class, [
                'class'=> Skill::class,
                'choice_label'=> 'nom',
                'label'=> ' ',
                'required'=>true
            ])
            ->add('expertise', EntityType::class, [
                'class'=> Expertise::class,
                'choice_label'=> 'niveau',
                'label'=> ' ',
                'required'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LienUserSkill::class
        ]);
    }
}
