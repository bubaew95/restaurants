<?php
/**
 * Created by PhpStorm.
 * user: bubaew95
 * Date: 16.08.2018
 * Time: 20:18
 */
?>

<div class="list-group">

    <?php if($model) : ?>
        <?php foreach ($model as $key => $item) : ?>
            <a
                href="/page/<?= $item->tr_name?>"
                class="item-page list-group-item list-group-item-action"
                data-name="<?= $item->name?>">
                <?= ($key + 1)?>. <?= $item->name ?>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <h4>Нет доступных страниц</h4>
    <?php endif; ?>

</div>