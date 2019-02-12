<?php if ($model) : ?>
    <?php foreach($model as $item) : ?>
        <li>
            <i class="fa fa-angle-double-right"></i>
            <a href="<?= \yii\helpers\Url::current(['id_cat' => $item['id']])?>">
                <?= $item['name']?>
            </a>
        </li>
    <?php endforeach ?>
<?php endif ?>