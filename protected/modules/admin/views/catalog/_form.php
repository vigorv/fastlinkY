<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cflcatalog-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

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
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group'); ?>
		<?php echo $form->textField($model,'group',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'group'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dt'); ?>
		<?php echo $form->textField($model,'dt'); ?>
		<?php echo $form->error($model,'dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_visible'); ?>
		<?php echo $form->textField($model,'is_visible'); ?>
		<?php echo $form->error($model,'is_visible'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_confirm'); ?>
		<?php echo $form->textField($model,'is_confirm'); ?>
		<?php echo $form->error($model,'is_confirm'); ?>
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
		<?php echo $form->labelEx($model,'tp'); ?>
		<?php echo $form->textField($model,'tp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'tp'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'tth'); ?>
		<?php echo $form->textField($model,'tth',array('size'=>100,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'tth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sz'); ?>
		<?php echo $form->textField($model,'sz',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sz'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vtp'); ?>
		<?php echo $form->textField($model,'vtp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'vtp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chk_md5'); ?>
		<?php echo $form->textField($model,'chk_md5',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'chk_md5'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->