<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('Email')
            ->add('admission')
            ->add('Gender',ChoiceType::class,[
                'choices'  => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                ],
            ])
            ->add('date_of_birth',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('Adress',TextareaType::class)
            ->add('Phone',TelType::class)
            ->add('class')
            ->add('Nationality',CountryType::class)
            ->add('Password',RepeatedType::class,[
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                    ]),
                ]
            ])
            ->add('parent')
            ->add("file",FileType::class,array("label"=>"User image","required"=>false));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
