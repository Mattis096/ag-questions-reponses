<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class QuestionType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add('first_name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('last_name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(max: 255),
                ],
            ])
            ->add('club', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255),
                ],
            ])
            ->add('club_function', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('department', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('department_function', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('region', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('region_function', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('question_1', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 5000),
                ],
            ])
            ->add('question_2', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 5000),
                ],
            ])
            ->add('question_3', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length(max: 5000),
                ],
            ]);
    }
}