<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\StudentSearch;

class StudentSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('admission',TextType::class,[
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search by ID ...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentSearch::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
