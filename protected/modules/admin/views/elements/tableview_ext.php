
<?php
mb_internal_encoding("UTF-8");
if (!function_exists('substr_replace_mb')) {

    function substr_replace_mb($string, $replacement, $start, $length) {

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
    }

    function print_item($val, $key, $keys) {
        $str_len = mb_strlen($val);
        $title = '';
        if ($str_len > 33) {
            $title = $val;
            $val = substr_replace_mb($val, '...', 15, $str_len - 30);
        }
        if ($key == $keys[0]) {
            $val = '<a href="' . Yii::app()->createUrl('/admin/' . Yii::app()->controller->id . '/view/' . $val) . '">' . $val . '</a>';
        }
        echo '<td title="' . $title . '">' . $val . '</td>';
    }

}

if (($list) && (count($list)) > 0):
    $keys = array_keys($list[0]);
    ?>

    <table  id="Item_list" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th><input class="selectAllItems"name="Select All" type="checkbox" value=""/></th>
                <?php foreach ($keys as $key): ?>
                    <th><?= $key; ?></th>
    <?php endforeach; ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td><input class="selectAllItems"name="Select All" type="checkbox" value=""/></td>
                <?php foreach ($keys as $key): ?>
                    <td><?= $key; ?></td>
    <?php endforeach; ?>
            </tr>
        </tfoot>
        <tbody>
    <?php foreach ($list as $key => $list_item): ?>
                <tr>
                    <td><input name="items_selected" type="checkbox" value="<?php echo $list_item[$keys[0]]; ?>"/></td>
                <? array_walk($list_item, 'print_item', $keys); ?>
                </tr>
    <?php endforeach; ?>
        </tbody>
    </table>


    <div class="pagination">
        <?
        if (isset($pages))
            $wg = $this->widget('CLinkPager', array(
                'pages' => $pages,
                'header' => '',
                'maxButtonCount' => 10,
                    ));
        ?>
    </div>
<?php else: ?>
    <h4>Пока еще нет ни одной записи.</h4>
<?php endif; ?>

<script>
    $('.selectAllItems').click (function () {
        var checkedStatus = this.checked;
        $('#Item_list tbody tr').find('td:first :checkbox').each(function () {
            $(this).prop('checked', checkedStatus);
        });
    });
</script>


