<h3>Результаты поиска "<?= $search_text; ?>"</h3>
<?php if (!empty($items)): ?>
    <?php foreach ($items as $key => $value): ?>           
        <p> <?= (($pages->currentPage ) * 20 + $key + 1); ?>. <a href="<?= $value['url']; ?>"><?= $value['title']; ?></a></p>
    <?php endforeach; ?>
<?php else: ?>
    <h4><?= Yii::t('common', 'No results for your search'); ?></h4>
<?php endif; ?>


<?php if (isset($pages)): ?>
    <div class="pagination">
        <?php
        $wg = $this->widget('CLinkPager', array(
            'pages' => $pages,
            'cssFile' => false,
            'header' => '',
            'maxButtonCount' => 10,
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
            'prevPageLabel'=> '<',
            'nextPageLabel'=> '>',
                ));
        ?>
    </div>
<?php endif;
?>