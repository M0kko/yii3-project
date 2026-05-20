<?php

declare(strict_types=1);

namespace App\Web\Feedback;

use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

final class FeedbackData implements RulesProviderInterface
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    public function getRules(): array
    {
        return [
            'name' => [
                new Required(message: 'Имя обязательно'),
                new Length(min: 2, max: 100, message: 'Имя должно быть от 2 до 100 символов'),
            ],
            'email' => [
                new Required(message: 'Email обязателен'),
                new Email(message: 'Введите корректный email'),
            ],
            'message' => [
                new Required(message: 'Сообщение обязательно'),
                new Length(min: 10, max: 1000, message: 'Сообщение должно быть от 10 до 1000 символов'),
            ],
        ];
    }
}