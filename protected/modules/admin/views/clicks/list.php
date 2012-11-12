<?php
$this->breadcrumbs=array(
    'Cflcatalog Clicks'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List CFLCatalogClicks', 'url'=>array('index')),
    array('label'=>'Create CFLCatalogClicks', 'url'=>array('create')),
    array('label'=>'Update CFLCatalogClicks', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete CFLCatalogClicks', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage CFLCatalogClicks', 'url'=>array('admin')),
);
?>

<h1>View CFLCatalogClicks #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'catalog_id',
        'catalog_group_id',
        'created',
        'user_id',
        'zone',
        'ip',
        'catalog_sgroup_id',
        'server_id',
    ),
)); ?>