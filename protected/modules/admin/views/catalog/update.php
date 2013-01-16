<?php
$this->breadcrumbs=array(
	'Cflcatalogs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CFLCatalog', 'url'=>array('index')),
	array('label'=>'Create CFLCatalog', 'url'=>array('create')),
	array('label'=>'View CFLCatalog', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage CFLCatalog', 'url'=>array('admin')),
);
?>

<h1>Update CFLCatalog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>