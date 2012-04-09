<h3><?=Yii::t('common','Register');?></h3>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal',
        )
            ));
    // $form=new CActiveForm; // this just for autocomplete view. Leave it commented
    ?>
    <fieldset>
        <? //<p class="note">Fields with <span class="required">*</span> are required.</p>?>

        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'username', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'username',array('class' => 'text')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($model, 'password',array('class' => 'password')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>

        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'password_repeat', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($model, 'password_repeat',array('class' => 'password')); ?>
                <?php echo $form->error($model, 'password_repeat'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'email',array('class' => 'email')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->label($model, 'UserAgreement', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'UserAgreement'); ?>
                <?=Yii::t('user','Accept');?> <a href="<?=Yii::app()->createUrl('pages/agreement');?>"><?=Yii::t('user','UserAgreement');?></a>
                <?php echo $form->error($model, 'UserAgreement'); ?>
            </div>
        </div>


        <?php if (CCaptcha::checkRequirements()): ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $this->widget('CCaptcha'); ?>
                    <?php echo $form->textField($model, 'verifyCode',array('class' => 'text')); ?>
                </div>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        <?php endif; ?>
    </fieldset>
    <div class="form-actions">
        <?php echo CHtml::submitButton(Yii::t('user','Register'),array('class'=>'btn btn-primary')); ?>
        <a class="btn" href="/users/restore"><?=Yii::t('user','Restore');?></a>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
