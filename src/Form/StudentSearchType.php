<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

            ->add('name',TextType::class,[
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search by Name ...'
                ]
            ])

            ->add('class',EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'All Classes',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentSearch::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
