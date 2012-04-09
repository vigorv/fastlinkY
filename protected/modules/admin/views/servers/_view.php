<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->server_id), array('view', 'id'=>$data->server_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_addr')); ?>:</b>
    <?php echo CHtml::encode($data->server_addr); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_ip')); ?>:</b>
    <?php echo CHtml::encode($data->server_ip); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_port')); ?>:</b>
    <?php echo CHtml::encode($data->server_port); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_desc')); ?>:</b>
    <?php echo CHtml::encode($data->server_desc); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_ipv6')); ?>:</b>
    <?php echo CHtml::encode($data->server_ipv6); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_is_active')); ?>:</b>
    <?php echo CHtml::encode($data->server_is_active); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('server_priority')); ?>:</b>
    <?php echo CHtml::encode($data->server_priority); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_letter')); ?>:</b>
    <?php echo CHtml::encode($data->server_letter); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_group')); ?>:</b>
    <?php echo CHtml::encode($data->server_group); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('zone_id')); ?>:</b>
    <?php echo CHtml::encode($data->zone_id); ?>
    <br />

    */ ?>

</div>