<h4><?=Yii::t('common', 'My files');?></h4>
<?php
    mb_internal_encoding("UTF-8");
if (!function_exists('substr_replace_mb')) {
    function substr_replace_mb($string, $replacement, $start, $length) {
        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length); }

    function print_item($val, $key, $keys)
    {
        $str_len = mb_strlen($val);
        $title = '';
        if ($str_len > 33) {
            $title = $val;
            $val = substr_replace_mb($val, '...', 15, $str_len - 30);
        }
        echo '<td title="' . $title . '">' . $val . '</td>';
    }
}
if (($list) && (count($list)) > 0):
    ?>
<table id="Item_list" class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th><input class="selectAllItems" name="Select All" type="checkbox" value=""/></th>
        <th>name</th>
        <th>size</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td><input class="selectAllItems" name="Select All" type="checkbox" value=""/></td>
        <th>name</th>
        <th>size</th>
    </tr>
    </tfoot>
    <tbody>
    <form id="Items" method="POST">
        <?php foreach ($list as $key => $list_item): ?>
    <tr>
        <td><input name="ids[]" type="checkbox" value="<?php echo $list_item['id']; ?>"/></td>
        <td><?=$list_item['name'];?></td>
        <td><?=CFLUtils::formatSize($list_item['sz']);?></td>
    </tr>
        <?php endforeach; ?>
    </form>
    </tbody>
</table>
<a class="btn" href="#" onClick="return DeleteSelected();"><i class="icon-remove"></i> Delete Selected</a>


<?php if (isset($pages)): ?>
<div class="pagination">
    <?
    $wg = $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'maxButtonCount' => 10,
    ));
    ?>
</div>
<?php endif; ?>
<?php else: ?>
<h4>Пока еще нет ни одной записи.</h4>
<?php endif; ?>
<div id="Results"></div>
<script>
    $('.selectAllItems').click(function () {
        var checkedStatus = this.checked;
        $('#Item_list tbody tr').find('td:first :checkbox').each(function () {
            $(this).prop('checked', checkedStatus);
        });
    });
    function DeleteSelected(){
        var options = {
                target: "#Results",
                url: "/Catalog/deletefiles",
                success: function() {

                }
    };

    $("#Items").ajaxSubmit(options);
    }
</script>

