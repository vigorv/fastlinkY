<?php

class AdminModule extends CWebModule {

    public function init() {
        parent::init();

        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'admin/site/error',
            ),
                )
        );
    }

}

?>