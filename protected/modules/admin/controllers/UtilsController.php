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
            switch ($file['sgroup']){
                case 6:
                case 2:
                        $server = Yii::app()->params['uploadServer_sg2'];break;
                case 4: $server = Yii::app()->params['uploadServer'];break;
                default: echo "not there ".$file['sgroup']; Yii::app()->end();
            }
            $data=base64_encode($file['dir'] . '/' . $file['original_name']);
            $skey=md5($data.Yii::app()->params['master_key']);
            $url = 'http://' . $server. '/files/checkexists?data='.$data.'&key='.$skey;
            $data = file_get_contents($url);
            if ($data=="BAD"){
                $items[]= $file->id;
            }
        }
        $this->render('list',array('data'=>$items));
    }

    public function actionLinkEmpties(){
        $rmdata = new RMData();
        $rdata=$rmdata->FindNewsWithoutLinks();
        foreach ($rdata as $item){
            $xfields = RMData::xfieldsdataload($item['xfields']);
            if (isset($xfields['direct_links'])){
            $dlinks_data = $xfields['direct_links'];
            $dlinks_data  = str_replace('<br />',PHP_EOL,$dlinks_data );
            $dlinks_data  = str_replace('<br>',PHP_EOL,$dlinks_data );
            preg_match_all("/catalog\/viewv\/[0-9]+/", $dlinks_data,$data);
            $ids =array();
            foreach ($data as &$matches)
                foreach($matches as &$str)
                    $ids[] = substr($str,14);
            array_unique($ids,SORT_NUMERIC);
            foreach ($ids as $id){
                $catalog = CFLCatalog::model()->findByAttributes(array('group'=>0,'sgroup'=>2,'id'=>$id));
                if ($catalog){
                    $catalog->group = $item['id'];
                    $catalog->save();
                    echo "<p>Set $catalog->group for $id </p>";
                }
            }
           }
        }

    }
    
    public function actionCheckI($id=0){
        $rmdata =new RMData();
        $rmdata->CheckImport($id);
        $this->render('index');
    }
    
}