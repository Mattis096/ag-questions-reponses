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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class QuestionType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
           ->add('first_name', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Votre prénom',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'exemple@email.com',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                    new Length(max: 255),
                ],
            ])
            ->add('club', TextType::class, [
                'label' => 'Votre Club',
                'attr' => [
                    'placeholder' => 'Si vous êtes membre individuel, saisissez MI',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255),
                ],
            ])
            ->add('club_function', TextType::class, [
                'required' => false,
                'label' => 'Fonction exercée',
                'attr' => [
                    'placeholder' => 'Si aucune, laisser vide',
                ],
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('department', TextType::class, [
                'label' => 'Votre département',
                'attr' => [
                    'placeholder' => 'Votre Comité départemental',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('department_function', TextType::class, [
                'required' => false,
                'label' => 'Fonction exercée',
                'attr' => [
                    'placeholder' => 'Si aucune, laisser vide',
                ],
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('region', TextType::class, [
                'label' => 'Votre région',
                'attr' => [
                    'placeholder' => 'Votre Comité régional',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 100),
                ],
            ])
            ->add('region_function', TextType::class, [
                'required' => false,
                'label' => 'Fonction exercée',
                'attr' => [
                    'placeholder' => 'Si aucune, laisser vide',
                ],
                'constraints' => [
                    new Length(max: 255),
                ],
            ])
            ->add('question_1', TextareaType::class, [
                'label' => 'Question 1',
                'attr' => [
                    'placeholder' => 'Votre question (500 caractères max)',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 500),
                ],
            ])
            ->add('question_2', TextareaType::class, [
                'required' => false,
                'label' => 'Question 2',
                'attr' => [
                    'placeholder' => 'Votre question (500 caractères max)',
                ],
                'constraints' => [
                    new Length(max: 500),
                ],
            ])
            ->add('question_3', TextareaType::class, [
                'required' => false,
                'label' => 'Question 3',
                'attr' => [
                    'placeholder' => 'Votre question (500 caractères max)',
                ],
                'constraints' => [
                    new Length(max: 500),
                ],
            ])
            ->add('consent', CheckboxType::class, [
                'label' => sprintf(
                    'En soumettant ce formulaire, j’accepte que la Fédération Française de Cyclotourisme collecte les données saisies dans le cadre de l’Assemblée générale de %s (%s).',
                    $options['event_city'],
                    $options['event_department'],
                ),
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new IsTrue(
                        message: 'Vous devez accepter cette condition pour envoyer le formulaire.'
                    ),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'event_city' => '',
            'event_department' => '',
        ]);
    }
}