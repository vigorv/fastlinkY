<?php

class ImportsController extends AdmController {

    public function beforeAction($action) {
        parent::beforeAction($action);
        if (Yii::app()->params['imports'] === true)
            return true;
        else
            $this->render ('/elements/messages', array ('msg' => "<h3>Imports not allowed</h3>"));
        ;
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionImportRM() {
        $rmData = new RMData();
        $rmData->RunImport();
    }

    public function actionImportRMZones() {
        $rmData = new RMData();
        $rmData->ConvertZones();
    }

    public function actionImportRMServers() {
        $rmData = new RMData();
        $rmData->ConvertServers();
    }

    public function actionImportFL() {
        $flData = new FLData();
        $flData->RunImport();
    }

    public function actionImportFLUsers() {
        $flData = new FLData();
        $flData->convertUsers();
    }

    public function actionImportFLServers() {
        $flData = new FLData();
        $flData->ConvertServers();
    }

}

?>