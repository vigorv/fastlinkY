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
            //var_dump($skey);
            // var_dump($suri);
            if ($rhash == $lhash) {
                return true;
            } else
                echo base64_encode(serialize(array('error_message' => "bad hash")));
        } else
            echo base64_encode(serialize(array('error_message' => "nodata")));
        exit();
    }

    public function actionUpload() {
        $fileInfo = @unserialize(base64_decode($this->fdata));
        if ($fileInfo) {
            $file = new CFLCatalog();
            $file->chk_md5 = $fileInfo['md5'];
            $file->sz = $fileInfo['size'];
            $file->title = $file->name = $fileInfo['name'];
            $file->original_name = $fileInfo['src'];
            $file->dir = $fileInfo['path'];
            $file->dt = date("m/d/y g:i A");
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
                if ($file->sgroup > 0) {
                    if (isset($fileInfo['group']))
                        $file->group = $fileInfo['group'];
                    else
                        $file->group = 0;
                }
                else
                    $file->group = 0;
                if ($file->save()) {
                    if (($file->group == 0) && ($file->sgroup == 4))
                        $file->group = $file->id;
                    $file->save();
                    echo base64_encode(serialize(array('id' => $file->id)));
                } else
                    echo base64_encode(serialize(array('error_message' => 'save failed')));
            } else
                echo base64_encode(serialize(array('error_message' => "unknown server")));
        } else
            echo base64_encode(serialize(array('error_message' => "bad data")));
        exit();
    }

    public function actionUploadA() {
        $fileInfo = @unserialize(base64_decode($this->fdata));
        if ($fileInfo) {
            $file = new CFLCatalog();
            $file->chk_md5 = $fileInfo['md5'];
            $file->sz = $fileInfo['size'];
            $file->title = $file->name = $fileInfo['name'];
            $file->original_name = $fileInfo['src'];
            $file->dir = $fileInfo['path'];
            $file->dt = date("m/d/y g:i A");
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
                if ($file->sgroup > 0) {
                    if (isset($fileInfo['group']))
                        $file->group = $fileInfo['group'];
                    else
                        $file->group = 0;
                }
                else
                    $file->group = 0;
                if ($file->save()) {
                    if (($file->group == 0) && ($file->sgroup == 4))
                        $file->group = $file->id;
                    $file->save();
                    echo base64_encode(serialize(array('id' => $file->id)));
                } else
                    echo base64_encode(serialize(array('error_message' => 'save failed')));
            } else
                echo base64_encode(serialize(array('error_message' => "unknown server")));
        } else
            echo base64_encode(serialize(array('error_message' => "bad data")));
        exit();
    }

    public function actionData() {
        $data = unserialize(base64_decode($this->fdata));
        if ($data) {
            //var_dump($data);
            if (isset($data['gid']) && ($data['gid'] > 0) && isset($data['ids']) && count($data['ids'])) {
                $gid = (int) $data['gid'];
                $ids_list = implode('","', $data['ids']);
                if (CFLCatalog::model()->setGid($gid, $ids_list))
                    echo "OK";
                else
                    var_dump(CFLCatalog::model()->getErrors());
                exit();
            }
            else
                echo "Not set";
        } else
            echo "Bad";
        exit();
    }

}