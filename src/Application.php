<?php

declare(strict_types=1);

namespace App;

use App\Form\FormFactory;
use App\Form\QuestionType;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Translator;

final class Application
{
    public function run(): void
    {
        $formFactory = FormFactory::create();

        $form = $formFactory->create(QuestionType::class);

        $loader = new FilesystemLoader([
            dirname(__DIR__) . '/templates',
            dirname(__DIR__) . '/vendor/symfony/twig-bridge/Resources/views/Form',
        ]);

        $twig = new Environment($loader);
        $translator = new Translator('fr');
        $twig->addExtension(new TranslationExtension($translator));

        $rendererEngine = new TwigRendererEngine(
            ['form_div_layout.html.twig'],
            $twig,
        );

        $csrfTokenManager = new CsrfTokenManager();

        $formRenderer = new FormRenderer(
            $rendererEngine,
            $csrfTokenManager,
        );

        $twig->addRuntimeLoader(
            new class($formRenderer) implements \Twig\RuntimeLoader\RuntimeLoaderInterface {
                public function __construct(
                    private readonly FormRenderer $formRenderer,
                ) {
                }

                public function load(string $class): ?object
                {
                    if ($class === FormRenderer::class) {
                        return $this->formRenderer;
                    }

                    return null;
                }
            },
        );

        $twig->addExtension(new FormExtension());

        echo $twig->render('question_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}