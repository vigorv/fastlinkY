<?php

class UtilsController extends AdmController {

    public function actionIndex() {
     $this->render('index');
    }
    

    public function actionMakeCache(){
        $rmdata = new RMData();
        $rmdata->makeCache();
        $this->render('/elements/messages',array('msg'=>'makeCache'));
    }
    
    public function actionCheckNewsWithNoLinks(){       
        $rmdata = new RMData();
        $data=$rmdata->FindNewsWithoutLinks();
        $this->render('list2',array('data'=>$data));
    }
    
    public function actionCheckLinksWithNoNews(){
        $rmdata = new RMData();
        $data=$rmdata->FindLinksWithoutNews();
        $this->render('cataloglist',array('data'=>$data));
    }

    public function actionShowItemsWithNoFiles(){
        $files = Yii::app()->db->createCommand("Select * from fl_catalog where sgroup = 2")->query();
        $items = array();
        while($file = $files->read()){
            switch ($file->sgroup){
                case 2: $server = Yii::app()->params['uploadServer_sg2'];break;
                case 4: $server = Yii::app()->params['uploadServer'];break;
                default: echo "not there ".$file->sgroup; Yii::app()->end();
            }
            $data=base64_encode($file->dir . '/' . $file->original_name);
            $skey=md5($data.Yii::app()->params['master_key']);
            $url = 'http://' . $server. '/files/checkexists?data='.$data.'&key='.$skey;
            $data = file_get_contents($url);
            if ($data=="BAD"){
                $items[]= $file->id;
            }
        }
        $this->render('list',array('data'=>$items));
    }
    
    public function actionCheckI($id=0){
        $rmdata =new RMData();
        $rmdata->CheckImport($id);
        $this->render('index');
    }
    
}