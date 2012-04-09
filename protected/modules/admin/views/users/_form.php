<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'cflusers-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'site_role_id'); ?>
        <?php echo $form->textField($model,'site_role_id',array('size'=>11,'maxlength'=>11)); ?>
        <?php echo $form->error($model,'site_role_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>32,'maxlength'=>32)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password_date'); ?>
        <?php echo $form->textField($model,'password_date'); ?>
        <?php echo $form->error($model,'password_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>254)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'join_date'); ?>
        <?php echo $form->textField($model,'join_date'); ?>
        <?php echo $form->error($model,'join_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'last_visit'); ?>
        <?php echo $form->textField($model,'last_visit'); ?>
        <?php echo $form->error($model,'last_visit'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'last_activity'); ?>
        <?php echo $form->textField($model,'last_activity'); ?>
        <?php echo $form->error($model,'last_activity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'time_zone'); ?>
        <?php echo $form->textField($model,'time_zone'); ?>
        <?php echo $form->error($model,'time_zone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'langauge_id'); ?>
        <?php echo $form->textField($model,'langauge_id'); ?>
        <?php echo $form->error($model,'langauge_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'birthday'); ?>
        <?php echo $form->textField($model,'birthday'); ?>
        <?php echo $form->error($model,'birthday'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'last_ip'); ?>
        <?php echo $form->textField($model,'last_ip',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->error($model,'last_ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'join_ip'); ?>
        <?php echo $form->textField($model,'join_ip',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->error($model,'join_ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'confirmed_email'); ?>
        <?php echo $form->textField($model,'confirmed_email'); ?>
        <?php echo $form->error($model,'confirmed_email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'count_friends'); ?>
        <?php echo $form->textField($model,'count_friends'); ?>
        <?php echo $form->error($model,'count_friends'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'count_unread_msg'); ?>
        <?php echo $form->textField($model,'count_unread_msg'); ?>
        <?php echo $form->error($model,'count_unread_msg'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'salt'); ?>
        <?php echo $form->textField($model,'salt',array('size'=>3,'maxlength'=>3)); ?>
        <?php echo $form->error($model,'salt'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nickname'); ?>
        <?php echo $form->textField($model,'nickname',array('size'=>32,'maxlength'=>32)); ?>
        <?php echo $form->error($model,'nickname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'userAgreement'); ?>
        <?php echo $form->textField($model,'userAgreement'); ?>
        <?php echo $form->error($model,'userAgreement'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->