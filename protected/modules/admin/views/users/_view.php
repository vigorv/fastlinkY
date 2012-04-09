<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('site_role_id')); ?>:</b>
    <?php echo CHtml::encode($data->site_role_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
    <?php echo CHtml::encode($data->username); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
    <?php echo CHtml::encode($data->password); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('password_date')); ?>:</b>
    <?php echo CHtml::encode($data->password_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('join_date')); ?>:</b>
    <?php echo CHtml::encode($data->join_date); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('last_visit')); ?>:</b>
    <?php echo CHtml::encode($data->last_visit); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_activity')); ?>:</b>
    <?php echo CHtml::encode($data->last_activity); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('time_zone')); ?>:</b>
    <?php echo CHtml::encode($data->time_zone); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('langauge_id')); ?>:</b>
    <?php echo CHtml::encode($data->langauge_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
    <?php echo CHtml::encode($data->birthday); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_ip')); ?>:</b>
    <?php echo CHtml::encode($data->last_ip); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('join_ip')); ?>:</b>
    <?php echo CHtml::encode($data->join_ip); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('confirmed_email')); ?>:</b>
    <?php echo CHtml::encode($data->confirmed_email); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('count_friends')); ?>:</b>
    <?php echo CHtml::encode($data->count_friends); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('count_unread_msg')); ?>:</b>
    <?php echo CHtml::encode($data->count_unread_msg); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
    <?php echo CHtml::encode($data->salt); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('nickname')); ?>:</b>
    <?php echo CHtml::encode($data->nickname); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('userAgreement')); ?>:</b>
    <?php echo CHtml::encode($data->userAgreement); ?>
    <br />

    */ ?>

</div>