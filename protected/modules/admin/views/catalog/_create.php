<?php
$this->breadcrumbs=array(
    'CFLCatalog'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List CFLCatalog', 'url'=>array('index')),
    array('label'=>'Manage CFLCatalog', 'url'=>array('admin')),
);
?>

<h1>Create CFLCatalog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>