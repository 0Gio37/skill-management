<?php

namespace App\Form;

use App\Entity\Profil;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (in_array('ROLE_ADMIN', $options['role'])) {
            $builder
                ->add(
                    'email',
                    EmailType::class,
                    [
                        'required' => true
                    ]
                )
                ->add(
                    'roles',
                    ChoiceType::class,
                    [
                        'choices' => [
                            'ADMIN' => "ROLE_ADMIN",
                            'Structure' => "ROLE_STRUCTURE",
                            'Utilisateur' => "ROLE_USER"
                        ],
                        'required' => true,
                        'multiple' => true,
                        'expanded' => true
                    ]
                )
                ->add(
                    'password',
                    RepeatedType::class,
                    [
                        'type' => PasswordType::class,
                        'invalid_message' => 'le mot de passe et la confirmation doivent être identique',
                        'required' => true,
                        'first_options' => [
                            'label' => 'Password'
                        ],
                        'second_options' => [
                            'label' => 'confirmer le password'
                        ]
                    ]
                )
                ->add(
                    'nom',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'prenom',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'adresse',
                    TextType::class,
                    [

                        'required' => true,
                    ]
                )
                ->add(
                    'cp',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'ville',
                    TextType::class,
                    [

                        'required' => true,
                    ]
                )
                ->add(
                    'telephone',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'etat',
                    ChoiceType::class,
                    [
                        'choices' => [
                            'Dans la société' => true,
                            'A quitté la société' => false
                        ]
                    ]
                )
                ->add(
                    'profil',
                    EntityType::class,
                    [
                        'class' => Profil::class,
                        'choice_label' => 'nom',
                    ]
                )
        ;} else {
            $builder
                ->add(
                    'nom',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'prenom',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'adresse',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'cp',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                )
                ->add(
                    'ville',
                    TextType::class,
                    [

                        'required' => true,
                    ]
                )
                ->add(
                    'telephone',
                    TextType::class,
                    [
                        'required' => true,
                    ]
                );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => ['ROLE_USER']
        ]);
    }
}
