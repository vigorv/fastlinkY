<html>
<head>

    <link rel="stylesheet" type="text/css" href="/css/global.css"/>

    <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    Yii::app()->getClientScript()->registerCoreScript('jquery.cookie');
    Yii::app()->getClientScript()->registerScriptFile('/js/jquery.form.js');

    Yii::app()->clientScript->registerScriptFile('/js/flowplayer-3.2.8.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/jquery.tools.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/jquery.placeholder.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/flowplayer.playlist-3.2.8.min.js');
    Yii::app()->clientScript->registerScriptFile('/js/flowplayer.ipad-3.2.8.min.js');
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>

    <div id="head" style="width:600px;height:100px;">
        <div class="logo"><a href="/" title="<?= Yii::t('common', 'Home'); ?>"></a></div>
    </div>
    <div style="width:600px; align:left;height:400px;" >
    <? echo $content; ?>
    </div>

</body>
</html>