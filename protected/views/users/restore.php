
<h3><?= Yii::t('user', 'Restore'); ?></h3>


<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'restore-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'email'); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
    </div>


    <?php if (CCaptcha::checkRequirements()): ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
            <?php $this->widget('CCaptcha'); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'verifyCode', array('class' => 'text')); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
          
        </div>
    <?php endif; ?>

    <div class="form-actions">

        <?php echo CHtml::submitButton(Yii::t('user', 'Restore'), array('class' => 'btn btn-primary')); ?>
        <a class="btn" href="/users/login"><?=Yii::t('common','Cancel');?></a>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
