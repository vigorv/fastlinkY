<?php
$this->breadcrumbs=array(
	'Cflpages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CFLPages', 'url'=>array('index')),
	array('label'=>'Manage CFLPages', 'url'=>array('admin')),
);
?>

<h1>Create CFLPages</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>