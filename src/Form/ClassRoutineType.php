<?php

namespace App\Form;

use App\Entity\ClassRoutine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class ClassRoutineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('day',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('start',TimeType::class,[
                'widget' => 'single_text',
            ])
            ->add('end',TimeType::class,[
                'widget' => 'single_text',
            ])
            ->add('class')
            ->add('subject')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassRoutine::class,
        ]);
    }
}
