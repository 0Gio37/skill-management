<?php

namespace App\Form;

use App\Entity\Archives;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArchivesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>[
                    'style' => 'width:75%',
                ]
            ])
            ->add('archive', FileType::class, [
                'label'=>" ",
                'multiple'=>false,
                'mapped'=> false,
                'required'=>true,
                'attr'=>[
                    'style' => 'width:100%'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Archives::class,
        ]);
    }
}
