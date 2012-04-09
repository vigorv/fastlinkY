
<form>
    <label for="ip">Check IP:</label>
    <input name="ip" type="text" placeholder="127.0.0.1"/>      
</form>



<?php
if (isset($zone_view))
    echo $zone_view;
?>

<br/>

<a href="<?= Yii::app()->createUrl('/admin/' . Yii::app()->controller->id . '/add'); ?>"><i class="icon-plus"></i>Добавить</a>

<?php

echo $table;

if (isset($tableR))
    echo $tableR;