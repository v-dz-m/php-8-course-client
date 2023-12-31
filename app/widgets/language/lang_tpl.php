<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= PATH ?>/assets/img/lang/<?= \wfm\App::$app->getProperty('language')['code'] ?>.png" alt="">
    </a>
    <ul class="dropdown-menu" id="languages">
        <li>
            <?php foreach ($this->languages as $k => $v): ?>
                <?php if (\wfm\App::$app->getProperty('language')['code'] == $k) continue; ?>
                <button class="dropdown-item" data-langcode="<?= $k ?>">
                    <img src="<?= PATH ?>/assets/img/lang/<?= $k ?>.png" alt="">
                    <?= $v['title'] ?>
                </button>
            <?php endforeach; ?>
        </li>
    </ul>
</div>
