<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      
        ->add('email',EmailType::class,[
            'label'=> 'Email',
            'attr' => [
                'placeholder' => 'Email',
                'autocomplete' => 'off',
                'class' => 'nes-input is-success',
                'required' => true,
            ]
        ])
        ->add('password' ,PasswordType::class,[
            'label'=> 'Pass',
            'attr' => [
                'placeholder' => 'Pass',
                'autocomplete' => 'off',
                'class' => 'nes-input is-error',
                'required' => true,
            ]
        ])
        ->add('name',TextType::class,[
            'label'=> 'Name',
            'attr' => [
                'placeholder' => 'Name',
                'autocomplete' => 'off',
                'class' => 'nes-input is-warning',
                'required' => true,
            ]
        ])
        ->add('biography',TextType::class,[
            'label'=> 'Biography',
            'attr' => [
                'placeholder' => 'Biography',
                'autocomplete' => 'off',
                'class' => 'nes-input is-primary',
                'required' => true,
            ]
        ])
        ->add('submit',SubmitType::class,[
            'label'=> 'Save',
            'attr' => [
                'class' => 'nes-btn is-primary btn-submit'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
