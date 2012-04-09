<?php
$this->breadcrumbs=array(
    'Cflservers'=>array('index'),
    $model->server_id=>array('view','id'=>$model->server_id),
    'Update',
);

$this->menu=array(
    array('label'=>'List CFLServers', 'url'=>array('index')),
    array('label'=>'Create CFLServers', 'url'=>array('create')),
    array('label'=>'View CFLServers', 'url'=>array('view', 'id'=>$model->server_id)),
    array('label'=>'Manage CFLServers', 'url'=>array('admin')),
);
?>

<h1>Update CFLServers <?php echo $model->server_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>