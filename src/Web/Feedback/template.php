<?php
/**
 * @var FeedbackData $formData
 * @var array $errors
 * @var bool $isSuccess
 */
?>
<section class="feedback-page">
    <h1>Обратная связь</h1>
    <p>Заполните форму. Поля <strong>Имя</strong>, <strong>Email</strong> и <strong>Сообщение</strong> обязательны.</p>

    <?php if ($isSuccess): ?>
        <div class="alert alert-success">
            ✅ Спасибо! Ваше сообщение принято.
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Ошибки заполнения:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/feedback" method="post" class="feedback-form" novalidate>
        <div class="form-row">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars((string)$formData->name, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="form-row">
            <label for="email">Электронная почта</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars((string)$formData->email, ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="form-row">
            <label for="message">Сообщение</label>
            <textarea id="message" name="message" rows="8"><?= htmlspecialchars((string)$formData->message, ENT_QUOTES, 'UTF-8') ?></textarea>
            <div id="message-info" class="message-info"></div>
        </div>
        <div class="form-row">
            <button type="submit">Отправить</button>
        </div>
    </form>
</section>