<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="ru" />
    <!--[if lt IE 8]><link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" type="text/css" media="screen, projection"><![endif]-->

        <?php
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/admin.css');
        Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl . '/css/bootstrap.min.css');

        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerCoreScript('jquery.cookie');
        Yii::app()->getClientScript()->registerCoreScript('jquery.form');
        ?>


    </head>
    <body>
        <div id="container">
            <div class="Panel_H">
                <?php
                $this->pageTitle = Yii::app()->name;
                ?>
                <div class="P_section_1">
                    <h1 id="title">Admin</h1>
                </div>
            </div>
            <div class="Panel_V P_section_1">

                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'General', 'url' => array('site/index')),
                        array('label' => 'Catalog', 'url' => array('catalog/index')),
                        array('label' => 'Clicks', 'url' => array('clicks/index')),
                        array('label' => 'Pages', 'url' => array('pages/index')),
                        array('label' => 'Imports', 'url' => array('imports/index')),
                        array('label' => 'Users', 'url' => array('users/index')),
                        array('label' => 'Utils', 'url' => array('utils/index')),
                        array('label' => 'Servers', 'url' => array('servers/index')),
                        array('label' => 'Zones', 'url' => array('zones/index')),
                    ),
                    'htmlOptions' => array('class' => 'ItemList_v_1'),
                        )
                );
                /*
                  <li ><a href="<?php echo $this->createUrl('/admin'); ?>">Index</a></li>
                  <li><a href="<?php echo $this->createUrl('/users/admin'); ?>">Users</a></li>
                  <li><a href="#">Groups</a></li>
                  <li><a href="<?php echo $this->createUrl('/films/admin'); ?>">Films</a></li>
                 */
                ?>


            </div>
            <div class="Panel_V P_section_2">
                <?php if (Yii::app()->user->hasFlash('success')): ?>
                    <div class="flash-notice">
                        <?php echo Yii::app()->user->getFlash('success') ?>
                    </div>
                <?php endif ?>
                <?php if (Yii::app()->user->hasFlash('error')): ?>
                    <div class="flash-error">
                        <?php echo Yii::app()->user->getFlash('error') ?>
                    </div>
                <?php endif ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                $this->widget('zii.widgets.CMenu', array(
                    'items'=>$this->menu,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                ?>

                <?php echo $content; ?>
            </div>
        </div>
    </body>
</html>