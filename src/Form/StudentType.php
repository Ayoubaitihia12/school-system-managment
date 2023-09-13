<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('Email')
            ->add('Admission_id',TextType::class,[
                'constraints' => [
                    new Length([
                        'min' => 6,
                    ]),
                ]
            ])
            ->add('Gender',ChoiceType::class,[
                'choices'  => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
            ])
            ->add('Date_of_Birth')
            ->add('Adress')
            ->add('Phone',TelType::class)
            ->add('Classe')
            ->add('Nationality',CountryType::class)
            ->add('Password',RepeatedType::class,[
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}