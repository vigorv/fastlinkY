<?php
$this->breadcrumbs=array(
    'Cflusers'=>array('index'),
    $model->user_id=>array('view','id'=>$model->user_id),
    'Update',
);

$this->menu=array(
    array('label'=>'List CFLUsers', 'url'=>array('index')),
    array('label'=>'Create CFLUsers', 'url'=>array('create')),
    array('label'=>'View CFLUsers', 'url'=>array('view', 'id'=>$model->user_id)),
    array('label'=>'Manage CFLUsers', 'url'=>array('admin')),
);
?>

<h1>Update CFLUsers <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>