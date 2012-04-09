<?php

class UtilsController extends AdmController {

    public function actionIndex() {
     $this->render('index');
    }
    
    
    
    public function actionCheckNewsWithNoLinks(){       
        $rmdata = new RMData();
        $data=$rmdata->FindNewsWithoutLinks();
        $this->render('list',array('data'=>$data));
    }
    
    public function actionCheckLinksWithNoNews(){
        $rmdata = new RMData();
        $data=$rmdata->FindLinksWithoutNews();
        $this->render('list',array('data'=>$data));        
    }
    
    public function actionCheckI($id=0){
        $rmdata =new RMData();
        $rmdata->CheckImport($id);
        $this->render('index');
    }
    
}