
<h3><?= Yii::t('common', 'Login'); ?></h3>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'username'); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'password'); ?>
        <div class="controls">
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo $form->label($model, 'rememberMe'); ?>
        <div class="controls">
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->error($model, 'rememberMe'); ?>
        </div>
    </div>

    <div class="form-actions">

        <?php echo CHtml::submitButton(Yii::t('user','Login'), array('class' => 'btn btn-primary')); ?>
        <a class="btn" href="/users/restore"><?=Yii::t('user','Restore');?></a>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
