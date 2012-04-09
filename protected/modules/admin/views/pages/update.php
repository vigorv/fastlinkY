<?php
$this->breadcrumbs=array(
	'Cflpages'=>array('index'),
	$model->page_id=>array('view','id'=>$model->page_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CFLPages', 'url'=>array('index')),
	array('label'=>'Create CFLPages', 'url'=>array('create')),
	array('label'=>'View CFLPages', 'url'=>array('view', 'id'=>$model->page_id)),
	array('label'=>'Manage CFLPages', 'url'=>array('admin')),
);
?>

<h1>Update CFLPages <?php echo $model->page_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>