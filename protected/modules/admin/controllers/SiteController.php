<?php

class SiteController extends AdmController {

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    
    public function actionIndex() {
        if (isset($_POST['view_ip'])){
            $ip = trim(filter_var($_POST['view_ip'],FILTER_SANITIZE_STRING));
            if ($ip==''){
                Yii::app()->user->setstate('ip',null);
            } else
                Yii::app()->user->setstate('ip',$ip);
            $this->redirect('/admin');
        }
        if (isset($_GET['zone'])){
            $zone= (int)$_GET['zone'];
            $ip = CFLZones::getIpInZone($zone);

            if ($ip=='' || $zone == 0){
                Yii::app()->user->setstate('ip',null);
           } else
                Yii::app()->user->setstate('ip',$ip);
            $this->redirect('/admin');
        }

        
        $zones = CFLZones::model()->getActiveZones($this->ip);
        $zones_view = $this->renderPartial('/elements/tableprint',array('list'=>$zones),true);
        $this->render('index',array('zones_view'=>$zones_view,'zone_list'=>$this->zone_list));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}