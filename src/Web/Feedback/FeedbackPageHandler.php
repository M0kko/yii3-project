<?php
declare(strict_types=1);

namespace App\Web\Feedback;

use App\Web\Shared\Layout\PageRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Csrf\CsrfTokenInterface;

final class FeedbackPageHandler implements RequestHandlerInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private CsrfTokenInterface $csrfToken, // <-- Добавлен сервис CSRF
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $renderer = new PageRenderer();

        $html = $renderer->renderPage(
            __DIR__ . '/template.php',
            [
                'formData' => new FeedbackData(),
                'errors' => [],
                'isSuccess' => false,
                'csrfToken' => $this->csrfToken->getValue(), // <-- Передаем токен в шаблон
            ],
            'Форма обратной связи',
            [
                '/css/site.css',
                '/css/feedback.css',
            ],
            [
                '/js/feedback.js',
            ]
        );

        $response = $this->responseFactory->createResponse(200);
        $response->getBody()->write($html);

        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }
}