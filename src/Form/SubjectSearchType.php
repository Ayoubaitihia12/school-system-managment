<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Model\SubjectSearch;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SubjectSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type',ChoiceType::class,[
                'required' => false,
                'placeholder' => 'All',
                'choices'  => [
                    'Theory' => 'Theory',
                    'Pratical' => 'Pratical'
                ],
            ])
            ->add('class',EntityType::class,[
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
            'data_class' => SubjectSearch::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
