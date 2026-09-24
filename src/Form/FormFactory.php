<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Validator\Validation;

final class FormFactory
{
    public static function create(): FormFactoryInterface
    {
        $validator = Validation::createValidator();

        $csrfTokenManager = new CsrfTokenManager();

        return Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension($validator))
            ->addExtension(new CsrfExtension($csrfTokenManager))
            ->getFormFactory();
    }
}