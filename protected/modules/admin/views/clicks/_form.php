
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'cflcatalog-clicks-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'catalog_id'); ?>
        <?php echo $form->textField($model,'catalog_id',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'catalog_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'catalog_group_id'); ?>
        <?php echo $form->textField($model,'catalog_group_id'); ?>
        <?php echo $form->error($model,'catalog_group_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
        <?php echo $form->error($model,'created'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user_id'); ?>
        <?php echo $form->textField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'zone'); ?>
        <?php echo $form->textField($model,'zone'); ?>
        <?php echo $form->error($model,'zone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ip'); ?>
        <?php echo $form->textField($model,'ip',array('size'=>25,'maxlength'=>25)); ?>
        <?php echo $form->error($model,'ip'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'catalog_sgroup_id'); ?>
        <?php echo $form->textField($model,'catalog_sgroup_id'); ?>
        <?php echo $form->error($model,'catalog_sgroup_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_id'); ?>
        <?php echo $form->textField($model,'server_id'); ?>
        <?php echo $form->error($model,'server_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->