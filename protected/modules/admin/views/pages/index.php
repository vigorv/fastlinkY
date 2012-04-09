<?php
$this->breadcrumbs=array(
	'Cflpages',
);

$this->menu=array(
	array('label'=>'Create CFLPages', 'url'=>array('create')),
	array('label'=>'Manage CFLPages', 'url'=>array('admin')),
);
?>

<h1>Cflpages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
