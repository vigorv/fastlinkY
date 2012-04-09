<?php
$this->breadcrumbs=array(
    'Cflusers'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List CFLUsers', 'url'=>array('index')),
    array('label'=>'Create CFLUsers', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('cflusers-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Cflusers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'cflusers-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'user_id',
        'site_role_id',
        'username',
        'password',
        'password_date',
        'email',
        /*
        'join_date',
        'last_visit',
        'last_activity',
        'time_zone',
        'langauge_id',
        'birthday',
        'last_ip',
        'join_ip',
        'confirmed_email',
        'count_friends',
        'count_unread_msg',
        'salt',
        'nickname',
        'userAgreement',
        */
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>