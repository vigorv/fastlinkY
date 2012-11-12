<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('catalog_id')); ?>:</b>
    <?php echo CHtml::encode($data->catalog_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('catalog_group_id')); ?>:</b>
    <?php echo CHtml::encode($data->catalog_group_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
    <?php echo CHtml::encode($data->created); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('zone')); ?>:</b>
    <?php echo CHtml::encode($data->zone); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
    <?php echo CHtml::encode($data->ip); ?>
    <br />

    <?php /*
    <b><?php echo CHtml::encode($data->getAttributeLabel('catalog_sgroup_id')); ?>:</b>
    <?php echo CHtml::encode($data->catalog_sgroup_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('server_id')); ?>:</b>
    <?php echo CHtml::encode($data->server_id); ?>
    <br />

    */ ?>

</div>