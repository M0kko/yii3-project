<?php

declare(strict_types=1);

namespace App\Web\Feedback;

use App\Web\Shared\Layout\PageRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Yiisoft\Validator\Validator;

final class FeedbackSubmitHandler implements RequestHandlerInterface
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $input = $request->getParsedBody();
        $input = is_array($input) ? $input : [];

        $formData = new FeedbackData();
        $formData->name    = trim((string)($input['name'] ?? ''));
        $formData->email   = trim((string)($input['email'] ?? ''));
        $formData->message = trim((string)($input['message'] ?? ''));

        $validator = new Validator();
        $result = $validator->validate($formData->getRules(), $formData);

        $renderer = new PageRenderer();

        // Если валидация не прошла – показываем форму с ошибками (HTTP 422)
        if (!$result->isValid()) {
            $errors = $result->getErrorMessages();
            $output = '<h1>Ошибки валидации</h1><pre>' . print_r($errors, true) . '</pre>';
            $response = $this->responseFactory->createResponse(422);
            $response->getBody()->write($output);
            return $response;
        }

        // Валидация успешна – сохраняем данные в лог-файл
        $logEntry = json_encode([
            'name'       => $formData->name,
            'email'      => $formData->email,
            'message'    => $formData->message,
            'created_at' => date('Y-m-d H:i:s'),
        ], JSON_UNESCAPED_UNICODE) . PHP_EOL;

        file_put_contents(__DIR__ . '/../../../runtime/feedback.log', $logEntry, FILE_APPEND);

        // Показываем форму с сообщением об успехе
        $html = $renderer->renderPage(
            __DIR__ . '/template.php',
            [
                'formData'  => new FeedbackData(),
                'errors'    => [],
                'isSuccess' => true,
            ],
            'Форма обратной связи',
            ['/css/site.css', '/css/feedback.css'],
            ['/js/feedback.js']
        );

        $response = $this->responseFactory->createResponse(200);
        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html; charset=utf-8');
    }
}