<?php if ($item): 
    if (!isset($action)) $action='add';
    ?>

<form id="Item_add" method="POST" action="<? echo Yii::app()->createUrl('admin/'.Yii::app()->controller->id.'/'.$action);?>">
        <fieldset>
            <table  class="table table-striped table-bordered table-condensed">
                <thead>
                <th width="10">key</th>
                <th>value</th>
                <th>Comment</th>
                </thead>
                <tbody>
                    <?php foreach ($item as $column): ?>
                        <?php //echo var_dump($column);exit(); ?>
                        <?php if (!$column['Extra']): ?>
                            <tr>
                                <td>[<?=Yii::app()->controller->id;?>][<?= $column['Field'] ?>]</td>
                                <td>
                                    <?php if (!(strpos($column['Type'], 'text') === false)): ?>
                                        <textarea name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"></textarea>
                                    <?php elseif (!(strpos($column['Type'], 'tinyint(1)') === false)): ?>
                                        <input name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"type="radio" value="1"/> Yes
                                        <input name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"type="radio" value="0"/> No                                        
                                    <?php elseif (!(strpos($column['Type'], 'int') === false)): ?>
                                        <input name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"type="number" value=""/>
                                    <?php elseif (!(strpos($column['Type'], 'datetime') === false)): ?>
                                        <input id="<?= $column['Field'] ?>" name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"type="datetime" placeholder="2011-08-20 01:00:00" value=""/>
                                        <input type="checkbox" name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>_now]" onClick="$('#<?= $column['Field'] ?>').val(new Date());"/> Now
                                        
                                    <?php else: ?>

                                        <input name="<?=Yii::app()->controller->id;?>[<?= $column['Field'] ?>]"type="text" value=""/>
                                    <?php endif; ?>
                                </td>
                                <td><?= $column['Comment']; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </fieldset>
        <input type="submit" value="Add"/>

    </form>
<?php endif; ?>