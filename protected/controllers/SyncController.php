<?php

class SyncController extends CController {

    var $fdata;
    var $ip;

    public function beforeAction($action) {
        parent::beforeAction($action);
        //  redefine('YII_DEBUG',false);
        $suri = Yii::app()->getBaseUrl(true) . '/';
        $this->ip = $ip = Yii::app()->request->getUserHostAddress();
        if (isset($_REQUEST['key']) && isset($_REQUEST['fdata'])) {
            $skey = Yii::app()->params[$ip . '_skey'];
            $this->fdata = $fdata = $_REQUEST['fdata'];
            $rhash = $_REQUEST['key'];
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
            } else{
                echo base64_encode(serialize(array('error_message' => "bad hash ")));
                Yii::log(base64_decode($this->fdata),CLOGGER::LEVEL_ERROR,"application");
            }
        } else{
            echo base64_encode(serialize(array('error_message' => "nodata")));
        }
        return false;
    }

    public function actionUpload() {
        $fileInfo = @unserialize(base64_decode($this->fdata));

        if ($fileInfo) {
            $file = new CFLCatalog();
            if (isset($fileInfo['uid'])){
                $record = CFLUsers::model()->findByPk($fileInfo['uid']);
                if($record){
                    $key= CFLUsers::UKey($record);
                    if($key==$fileInfo['key']){
                        $file->user_id = $fileInfo['uid'];
                    }
                }
            }


            $file->chk_md5 = $fileInfo['md5'];
            $file->sz = $fileInfo['size'];
            $file->title = $file->name = $fileInfo['name'];
            $file->original_name = $fileInfo['src'];
            $file->dir = $fileInfo['path'];
            $file->dt = date( 'Y-m-d H:i:s' );
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
                    //if (($file->group == 0) && ($file->sgroup == 4))
                      //  $file->group = $file->id;
                    $file->save();
                    echo base64_encode(serialize(array('id' => $file->id)));
                } else{
                    echo base64_encode(serialize(array('error_message' => 'save failed','error_data'=>$file->getErrors())));
                }
            } else
                echo base64_encode(serialize(array('error_message' => "unknown server")));
        } else
            echo base64_encode(serialize(array('error_message' => "bad data")));
        exit();
    }

    public function actionCheck(){
        $data = unserialize(base64_decode($this->fdata));
        if ($data) {
            if (isset($data['dir'])  && isset($data['fname'])){
                $item = CFLCatalog::model()->findByAttributes(array('dir'=>$data['dir'],'original_name'=>$data['fname']));
                if ($item && $item->id){
                    echo "OK";
                    Yii::app()->end();
                }
            }
        }
        echo "BAD";
    }

    public function actionData() {
        $data = unserialize(base64_decode($this->fdata));
        if ($data) {
            //var_dump($data);
            if (isset($data['gid']) && ($data['gid'] > 0) && isset($data['ids']) && count($data['ids'])) {
                $gid = (int) $data['gid'];
                $ids_list = implode('","', $data['ids']);
                if (CFLCatalog::model()->FreeGidNotInListGid($gid, $ids_list)>=0)
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