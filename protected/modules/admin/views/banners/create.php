<?php
$this->breadcrumbs=array(
    'CFLBanners'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List CFLBanners', 'url'=>array('index')),
   // array('label'=>'Manage CFLCatalog', 'url'=>array('admin')),
);
?>

<h1>Create CFLBanners</h1>

<?php echo $this->renderPartial('_form_create', array('model'=>$model)); ?>