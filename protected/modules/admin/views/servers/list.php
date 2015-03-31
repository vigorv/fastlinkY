<?php
$this->breadcrumbs=array(
    'Cflservers'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'List CFLServers', 'url'=>array('index')),
    array('label'=>'Create CFLServers', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('cflservers-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Manage Cflservers</h1>

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
    'id'=>'cflservers-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'server_id',

        'server_ip',
        'server_port',
        'server_desc',
        'server_letter',
        'zone_id',
        'server_group',
        'server_is_active',
        'server_priority',
        'server_addr',
        /*
        'server_ipv6',



        */
        array(
            'class'=>'CButtonColumn',
        	'template'=> '{on} {off} {view} {update} {delete}',
            'buttons' => array(
                      'on' => array(
                                       'label' => 'Деактивировать',
                                        'imageUrl' => Yii::app()->baseUrl.'/images/nochek.gif',
                                         'visible' => '$data->server_is_active == 1',
                                          'url'   => 'Yii::app()->controller->createUrl("activate",array("id"=>$data->primaryKey,"state"=>0))',
					    'options' => array( 'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("cflservers-grid")}')),
                                          
                               ),
                    	'off' => array(
                    	                    'label' => 'Активировать',
                    	                    'imageUrl' => Yii::app()->baseUrl.'/images/chek.gif',
                    	                    'visible' => '$data->server_is_active == 0',
                    	                    'url'   => 'Yii::app()->controller->createUrl("activate",array("id"=>$data->primaryKey,"state"=>1))',
					    'options' => array( 'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("cflservers-grid")}')),
                    	                    
                    	                     ),
                               
	    ),
        ),
    ),
)); ?>
