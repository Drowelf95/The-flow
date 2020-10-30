<?php

namespace App\Form;

use App\Entity\Segments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SegmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('part', TextType::class)
            ->add('title1', TextType::class)
            ->add('message1', TextareaType::class)
            ->add('link1', TextType::class)
            ->add('title2', TextType::class)
            ->add('message2', TextareaType::class)
            ->add('link2', FileType::class, [
                'data_class' => null,
                'required'=>false
                ])
            ->add('link_s1', FileType::class, [
                'mapped' => false,
                'data_class' => null,
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Select a file'
                    ]
                ])
            ->add('link_s2', FileType::class, [
                'mapped' => false,
                'data_class' => null,
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Select a file'
                    ]
                ])
            ->add('link_s3', FileType::class, [
                'mapped' => false,
                'data_class' => null,
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Select a file'
                    ]
                ])
            ->add('link3', TextType::class, [
                'mapped' => false,
                'data_class' => null,
                'required'=>false,
                'attr' => [
                    'placeholder' => 'Select a file'
                    ]
                ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Segments::class,
        ]);
    }
}
