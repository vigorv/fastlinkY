<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'server_id'); ?>
        <?php echo $form->textField($model,'server_id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_addr'); ?>
        <?php echo $form->textField($model,'server_addr',array('size'=>60,'maxlength'=>64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_ip'); ?>
        <?php echo $form->textField($model,'server_ip',array('size'=>10,'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_port'); ?>
        <?php echo $form->textField($model,'server_port'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_desc'); ?>
        <?php echo $form->textField($model,'server_desc',array('size'=>60,'maxlength'=>64)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_ipv6'); ?>
        <?php echo $form->textField($model,'server_ipv6',array('size'=>16,'maxlength'=>16)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_is_active'); ?>
        <?php echo $form->textField($model,'server_is_active'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_priority'); ?>
        <?php echo $form->textField($model,'server_priority'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_letter'); ?>
        <?php echo $form->textField($model,'server_letter',array('size'=>32,'maxlength'=>32)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_group'); ?>
        <?php echo $form->textField($model,'server_group'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'zone_id'); ?>
        <?php echo $form->textField($model,'zone_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->