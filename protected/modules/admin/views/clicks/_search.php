<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'catalog_id'); ?>
        <?php echo $form->textField($model,'catalog_id',array('size'=>10,'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'catalog_group_id'); ?>
        <?php echo $form->textField($model,'catalog_group_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'user_id'); ?>
        <?php echo $form->textField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'zone'); ?>
        <?php echo $form->textField($model,'zone'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'ip'); ?>
        <?php echo $form->textField($model,'ip',array('size'=>25,'maxlength'=>25)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'catalog_sgroup_id'); ?>
        <?php echo $form->textField($model,'catalog_sgroup_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'server_id'); ?>
        <?php echo $form->textField($model,'server_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->