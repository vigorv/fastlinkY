<?php
 /** @var CActiveForm $form */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'cflcatalog-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'original_name'); ?>
        <?php echo $form->textField($model,'original_name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'original_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'group'); ?>
        <?php echo $form->textField($model,'group',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'group'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'dir'); ?>
        <?php echo $form->textField($model,'dir',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'dir'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sgroup'); ?>
        <?php echo $form->textField($model,'sgroup',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'sgroup'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'sz'); ?>
        <?php echo $form->textField($model,'sz',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'sz'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'tth'); ?>
        <?php echo $form->textField($model,'tth',array('size'=>100,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'tth'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->