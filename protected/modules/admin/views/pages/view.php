<?php
$this->breadcrumbs = array(
    'Cflpages' => array('index'),
    $model->page_id,
);

$this->menu = array(
    array('label' => 'List CFLPages', 'url' => array('index')),
    array('label' => 'Create CFLPages', 'url' => array('create')),
    array('label' => 'Update CFLPages', 'url' => array('update', 'id' => $model->page_id)),
    array('label' => 'Delete CFLPages', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->page_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CFLPages', 'url' => array('admin')),
);
?>

<h1>View CFLPages #<?php echo $model->page_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'page_id',
        'page_name',
        'page_active',
        'parent_id',
        'alias',
        'created',
    ),
));
?>

