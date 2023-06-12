<?php

namespace App\Form;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',TextType::class,[
            'label'=> 'Name',
            'attr' => [
                'placeholder' => 'Name',
                'autocomplete' => 'off',
                'class' => 'nes-input is-success',
                'required' => true,
            ]
        ])
        ->add('description',TextType::class,[
            'label'=> 'Description',
            'attr' => [
                'placeholder' => 'Description',
                'autocomplete' => 'off',
                'class' => 'nes-input is-warning',
                'required' => true,
            ]
        ])
        ->add('photo',ChoiceType::class,[
            'label'=> 'Photo',
            'attr' => [
                'placeholder' => 'Photo',
                'autocomplete' => 'off',
                'class' => 'nes-input select',
                'required' => true,
            ],
            'choices' => Quote::PHOTOS
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
            'data_class' => Quote::class,
        ]);
    }
}
