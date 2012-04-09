<?php

class Controller extends CController {

    public $layout = '/layouts/fastlink';
    public $menu = array();
    public $breadcrumbs = array();
    public $identity = null;
    public $userPower;
    public $userGroupId;
    public $userInfo;
    public $active = 0; //СОДЕРЖИМОЕ ПОЛЯ active ТЕКУЩЕГО ОБЪЕКТА
    public $zone;
    public $ip;
    


    public function init() {
        parent::init();
        $app = Yii::app();

        $this->identity = new UserIdentity('', '');
        $this->identity->authenticate();

        if (isset($_GET['_lang'])) {
            $app->language = $_GET['_lang'];
            $app->session['_lang'] = $app->language;
        } else if (isset($app->session['_lang'])) {
            $app->language = $app->session['_lang'];
        }
    }

    public function beforeAction($action) {
        $this->userGroupId = intval(Yii::app()->user->getState('dmUserGroupId'));
        $this->userPower = intval(Yii::app()->user->getState('dmUserPower'));
        $this->userInfo = Yii::app()->user->getState('dmUserInfo');
        if (!empty($this->userInfo)) {
            $this->userInfo = unserialize($this->userInfo);
        }
        
        $ip = Yii::app()->user->getState('ip');
        if (!empty($ip)){
            $this->ip = $ip;
        }
        else
            $this->ip = Yii::app()->request->getUserHostAddress();
        $this->zone = CFLZones::model()->getActiveZoneslst($this->ip);

        

        if (Yii::app()->detectMobileBrowser->showMobile) {
            $this->layout = 'mobile';
        }
        if (Yii::app()->request->isAjaxRequest) {
            //    $this->renderPartial('_ajaxContent', $data);
            $this->layout = 'ajax';
        } else {
            //$this->layout='index';
            // $this->render('index', $data);
        }
        return true;
    }

    public function beforeRender($view) {
        $userPower = Yii::app()->user->getState('dmUserPower');
        if (!empty($this->active)) {
            if ($userPower < $this->active) {
                //Yii::app()->request->redirect('access_denied');
                //return false;
            }
        }
        return true;
    }

}