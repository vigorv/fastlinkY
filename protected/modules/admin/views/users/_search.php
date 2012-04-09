<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'user_id'); ?>
        <?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'site_role_id'); ?>
        <?php echo $form->textField($model,'site_role_id',array('size'=>11,'maxlength'=>11)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>254)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'join_date'); ?>
        <?php echo $form->textField($model,'join_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'last_visit'); ?>
        <?php echo $form->textField($model,'last_visit'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'last_activity'); ?>
        <?php echo $form->textField($model,'last_activity'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'time_zone'); ?>
        <?php echo $form->textField($model,'time_zone'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'langauge_id'); ?>
        <?php echo $form->textField($model,'langauge_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'birthday'); ?>
        <?php echo $form->textField($model,'birthday'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'last_ip'); ?>
        <?php echo $form->textField($model,'last_ip',array('size'=>16,'maxlength'=>16)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'join_ip'); ?>
        <?php echo $form->textField($model,'join_ip',array('size'=>16,'maxlength'=>16)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'confirmed_email'); ?>
        <?php echo $form->textField($model,'confirmed_email'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'count_friends'); ?>
        <?php echo $form->textField($model,'count_friends'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'count_unread_msg'); ?>
        <?php echo $form->textField($model,'count_unread_msg'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'salt'); ?>
        <?php echo $form->textField($model,'salt',array('size'=>3,'maxlength'=>3)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'nickname'); ?>
        <?php echo $form->textField($model,'nickname',array('size'=>32,'maxlength'=>32)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'userAgreement'); ?>
        <?php echo $form->textField($model,'userAgreement'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->