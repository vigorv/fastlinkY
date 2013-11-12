<?php
$this->breadcrumbs=array(
	'Cflbanners'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CFLBanners', 'url'=>array('index')),
	array('label'=>'Create CFLBanners', 'url'=>array('create')),
	array('label'=>'View CFLBanners', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage CFLBanners', 'url'=>array('admin')),
);
?>

<h1>Update CFLBanners <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>