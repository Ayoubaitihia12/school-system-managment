<?php

namespace App\Form;

use App\Entity\Holiday;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class HolidayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type',ChoiceType::class,[
                'choices'  => [
                    'College Holiday' => 'College Holiday',
                    'Public Holiday	' => 'Public Holiday',
                    'Semester leave' => 'Semester leave',
                ],
                'expanded' => true
            ])
            ->add('start',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('end',DateType::class,[
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Holiday::class,
        ]);
    }
}
