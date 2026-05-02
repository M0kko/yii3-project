<?php
/** @var string $pageTitle */
/** @var string $pageDescription */
?>
<section class="hero">
 <h2><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h2>
 <p><?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?></p>
</section>
<section class="modules-section">
 <h3>Модули проекта</h3>
 <p>
 Ниже отображается список модулей, получаемый с серверного JSON-маршрута.
 Данные запрашиваются клиентским JavaScript после загрузки страницы.
 </p>
 <div id="module-list" class="module-list"></div>
</section>

