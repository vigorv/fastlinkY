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
    public $userRole;
    public $zone_list;
    public $newLinks;
    

    public function init() {
        parent::init();
        $app = Yii::app();
        
       //этот хук позволяет вернуться на предыдущий URL при авторизации
       if($app->createUrl($app->user->loginUrl[0])!=$app->request->getUrl())
           $app->user->setReturnUrl($app->request->getUrl());
        $this->identity = new UserIdentity('', '');

        if($this->identity->authenticate())
            Yii::app()->user->login($this->identity);

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
        $this->userRole = Yii::app()->user->getState('role');
        if (!empty($this->userInfo)) {
            $this->userInfo = unserialize($this->userInfo);
        }
        if (isset($_GET['zone'])){
            $zone= (int)$_GET['zone'];
            $ip = CFLZones::getIpInZone($zone);
            if ($ip=='' || $zone == 0){
                Yii::app()->user->setstate('ip',null);
           } else
                Yii::app()->user->setstate('ip',$ip);
        }

        $ip = Yii::app()->user->getState('ip');
        if (!empty($ip)) {
            $this->ip = $ip;
        }
        else
            $this->ip = Yii::app()->request->getUserHostAddress();
        $this->zone = CFLZones::model()->getActiveZoneslst($this->ip);
        $criteria = new CDbCriteria();
        $criteria->order = 'zone_id';
        if($this->userRole==='admin'){
        $this->zone_list = CFLZones::model()->getCommandBuilder()
            ->createFindCommand(CFLZones::model()->tableSchema, $criteria)
            ->queryAll();
        $this->newLinks=CFLCatalog::model()->GetOnesOfZone();
        }

        if (Yii::app()->detectMobileBrowser->showMobile) {
            $this->layout = 'mobile';
        }
        if (isset($_GET['lay_mini'])) {
            $this->layout = 'mini';
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