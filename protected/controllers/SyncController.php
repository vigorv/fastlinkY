<?php

class SyncController extends CController {

    var $fdata;
    var $ip;

    public function beforeAction($action) {
        parent::beforeAction($action);
        //  redefine('YII_DEBUG',false);
        $suri = Yii::app()->getBaseUrl(true) . '/';
        $this->ip = $ip = Yii::app()->request->getUserHostAddress();
        if (isset($_GET['key']) && isset($_GET['fdata'])) {
            $skey = Yii::app()->params[$ip . '_skey'];
            $this->fdata = $fdata = $_GET['fdata'];
            $rhash = $_GET['key'];
            //echo $skey.PHP_EOL;
            //echo $fdata.PHP_EOL;
            //echo $suri.PHP_EOL;
            $lhash = md5($skey . $fdata . $suri);
//            echo $rhash.PHP_EOL;
//            echo $lhash.PHP_EOL;
            if ($rhash == $lhash) {
                return true;
            } else
                echo base64_encode(serialize(array('error_message' => "bad hash")));
        } else
            echo base64_encode(serialize(array('error_message' => "nodata")));
        exit();
    }

    public function actionUpload() {
        $fileInfo = unserialize(base64_decode($this->fdata));
        if ($fileInfo) {
            $file = new CFLCatalog();
            $file->chk_md5 = $fileInfo['md5'];
            $file->sz = $fileInfo['size'];
            $file->title = $file->name = $fileInfo['name'];
            $file->original_name = $fileInfo['src'];
            $file->dir = $fileInfo['path'];
            if (isset($fileInfo['user_id']) || (Yii::app()->params['guestUploads'] == true)) {
                if (isset($fileInfo['user_id']))
                    $file->user_id = $fileInfo['user_id'];
            } else {
                echo base64_encode(serialize(array('error_message' => "guest uploads not allowed")));
                exit();
            }
            $server = CFLServers::model()->find('server_ip = "' . $this->ip . '"');
            if ($server) {
                $file->sgroup = $server->server_group;
                if ($file->save()) {
                    $file->group = $file->id;
                    $file->save();
                    echo base64_encode(serialize(array('id' => $file->id)));
                } else
                    echo base64_encode(serialize(array('error_message'=>'save failed')));                
            } else
                echo base64_encode(serialize(array('error_message' => "unknown server")));
        } else
            echo base64_encode(serialize(array('error_message' => "bad data")));
        exit();
    }

    public function actionUploadA() {

        $fileInfo = unserialize(base64_decode($this->fdata));
        if ($fileInfo) {
            $file = new CFLCatalog();
            $file->chk_md5 = $fileInfo['md5'];
            $file->sz = $fileInfo['size'];
            $file->title = $file->name = $fileInfo['name'];
            $file->original_name = $fileInfo['src'];
            $file->dir = $fileInfo['path'];
            if ((Yii::app()->user->id) || (Yii::app()->params['guestUploads'] == true)) {
                $file->user_id = Yii::app()->user->id;
            } else {
                echo base64_encode(serialize(array('error_message' => "guest uploads not allowed")));
                Yii::app()->end();
            }
            $server = CFLServers::model()->find('server_ip = "' . $this->ip . '"');
            if ($server) {
                $file->sgroup = $server->server_group;
                if ($file->save()) {
                    $file->group = 0;
                    $file->save();
                    echo base64_encode(serialize(array('id' => $file->id)));
                }
            } else
                echo base64_encode(serialize(array('error_message' => "unknown server")));
        }
        exit();
    }

}