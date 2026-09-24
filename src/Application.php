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
use App\Config\AppConfig;
use App\Database\Connection;
use App\Repository\QuestionRepository;

final class Application
{
    public function run(): void
    {
        $projectDirectory = dirname(__DIR__);

        $config = AppConfig::fromEnvironment($projectDirectory);

        $connection = new Connection($config->getDatabasePath());
        $pdo = $connection->getPdo();

        $questionRepository = new QuestionRepository($pdo);

        $formFactory = FormFactory::create();

        $form = $formFactory->create(QuestionType::class, null, [
            'event_city' => $config->getEventCity(),
            'event_department' => $config->getEventDepartment(),
        ]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $form->submit($_POST[$form->getName()] ?? []);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $data['created_at'] = (new \DateTimeImmutable())->format('Y-m-d H:i:s');

                $questionRepository->create($data);

                header('Location: /?success=1');
                exit;
            }
        }

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
        $success = isset($_GET['success']) && $_GET['success'] === '1';
        echo $twig->render('question_form.html.twig', [
            'form' => $form->createView(),
            'success' => $success,

            'event_name' => $config->getEventName(),
            'event_city' => $config->getEventCity(),
            'event_department' => $config->getEventDepartment(),

            'event_dates_formatted' => $config->formatEventDates(
                $config->getEventStartDate(),
                $config->getEventEndDate(),
            ),

            'question_deadline_formatted' => $config->formatDate(
                $config->getQuestionDeadline()
            ),
        ]);
    }
}