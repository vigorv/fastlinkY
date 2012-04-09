<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'cflservers-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'server_addr'); ?>
        <?php echo $form->textField($model,'server_addr',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'server_addr'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_ip'); ?>
        <?php echo $form->textField($model,'server_ip',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'server_ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_port'); ?>
        <?php echo $form->textField($model,'server_port'); ?>
        <?php echo $form->error($model,'server_port'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_desc'); ?>
        <?php echo $form->textField($model,'server_desc',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'server_desc'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_ipv6'); ?>
        <?php echo $form->textField($model,'server_ipv6',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->error($model,'server_ipv6'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_is_active'); ?>
        <?php echo $form->textField($model,'server_is_active'); ?>
        <?php echo $form->error($model,'server_is_active'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_priority'); ?>
        <?php echo $form->textField($model,'server_priority'); ?>
        <?php echo $form->error($model,'server_priority'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_letter'); ?>
        <?php echo $form->textField($model,'server_letter',array('size'=>32,'maxlength'=>32)); ?>
        <?php echo $form->error($model,'server_letter'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_group'); ?>
        <?php echo $form->textField($model,'server_group'); ?>
        <?php echo $form->error($model,'server_group'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'zone_id'); ?>
        <?php echo $form->textField($model,'zone_id'); ?>
        <?php echo $form->error($model,'zone_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->