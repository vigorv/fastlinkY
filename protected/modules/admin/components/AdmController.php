<?php

class AdmController extends Controller {

    public $layout = 'admin';
    public $ip;
    public $zone;

    public function beforeAction($action) {
        parent::beforeAction($action);
        $userRole = Yii::app()->user->getState('role');

        $ip = Yii::app()->user->getState('ip');
        if (!empty($ip)) {
            $this->ip = $ip;
        }
        else
            $this->ip = Yii::app()->request->getUserHostAddress();
        $this->zone = CFLZones::model()->getActiveZoneslst($this->ip);
        if ($userRole == "admin")
            return true;
        else
            $this->redirect('/');
    }

}