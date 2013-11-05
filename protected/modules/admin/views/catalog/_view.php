
<div>
    <? Yii::app()->createUrl('/catalog/viewv/'.$data->id);?>
</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('original_name')); ?>:</b>
	<?php echo CHtml::encode($data->original_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('group')); ?>:</b>
	<?php echo CHtml::encode($data->group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dt')); ?>:</b>
	<?php echo CHtml::encode($data->dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_visible')); ?>:</b>
	<?php echo CHtml::encode($data->is_visible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_confirm')); ?>:</b>
	<?php echo CHtml::encode($data->is_confirm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dir')); ?>:</b>
	<?php echo CHtml::encode($data->dir); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sgroup')); ?>:</b>
	<?php echo CHtml::encode($data->sgroup); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tp')); ?>:</b>
	<?php echo CHtml::encode($data->tp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sz')); ?>:</b>
	<?php echo CHtml::encode($data->sz); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vtp')); ?>:</b>
	<?php echo CHtml::encode($data->vtp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chk_md5')); ?>:</b>
	<?php echo CHtml::encode($data->chk_md5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tth')); ?>:</b>
	<?php echo CHtml::encode($data->tth); ?>
	<br />

	*/ ?>

</div>