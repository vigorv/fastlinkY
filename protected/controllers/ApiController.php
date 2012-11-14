<?php

class ApiController extends Controller
{
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return true;
    }

    public function actionFileGroup($id=0,$sg=2){
        if ($id > 0) {
            $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group'=>$id,'sgroup'=>$sg));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group'=>$id,'sgroup'=>6));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group'=>$id,'sgroup'=>5));
            if (!empty($files)){
                $data=array('group'=>$id,'count'=>count($files));
                foreach ($files as $f)
                    $data['files'][]=$f['id'];
                echo serialize($data);
            }
        }
    }

    public function actionGroupOfFile($id=0){
        if ($id > 0) {
            $file = CFLCatalog::model()->cache(100)->findByPk($id);
            $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group'=>$file->group,'sgroup'=>$file->sgroup));
            /** @var CFLCatalog $file */
            if ($file && !empty($files)){
                $data=array('group'=>$file->group,'count'=>count($files));
                foreach ($files as $f)
                    $data['files'][]=$f['id'];
                echo serialize($data);
            }
        }
    }

    public function actionFilePath($item_id=0){
        if ($item_id > 0) {
            $file = CFLCatalog::model()->cache(1000)->findByPk($item_id);
            /** @var CFLCatalog $file */
            if ($file){
                if ($file->sgroup == 1) {
                    $letter = strtolower($file->dir[0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file->dir = '0-999/' . $file->dir;
                    } else
                        $file->dir = $letter . '/' . $file->dir;
                }
                $files = array($file->dir.'/'.$file->name);
                echo serialize($files);
            }
        }
    }

    public function actionFileGroupPath($item_id=0, $sg=2 ){
        if ($item_id > 0) {
            $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group'=>$item_id,'sgroup'=>$sg),array('order'=>'id'));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group'=>$item_id,'sgroup'=>5),array('order'=>'id'));;
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group'=>$item_id,'sgroup'=>6),array('order'=>'id'));;
            $res = array();
            foreach($files as $file){
                if ($file['sgroup'] == 1) {
                    $letter = strtolower($file['dir'][0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file['dir'] = '0-999/' . $file['dir'];
                    } else
                        $file['dir'] = $letter . '/' . $file['dir'];
                }
                $res[]= $file['dir'].'/'.$file['name'];
            }
            echo serialize($res);
        }
    }

    public function actionCloudNotReady($sg=2,$ftype='video'){
        switch($ftype){
            case 'video': $likes = '((original_name LIKE "%.avi") OR (original_name LIKE "%.mkv") OR (original_name LIKE "%.mp4"))';
                break;
            default: $likes =' 1=1';
        }

        $id_list = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('{{catalog}}')
                    ->where('(cloud_ready=0 AND sgroup = :sg) AND '.$likes,array(':sg'=>$sg))
                    ->order('id DESC')
                    ->limit(50)
                    ->queryAll();
        if (empty($id_list) && $sg==2)
            $id_list = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{catalog}}')
                ->where('(cloud_ready=0 AND sgroup = :sg) AND '.$likes,array(':sg'=>6))
                ->order('id DESC')
                ->limit(50)
                ->queryAll();

        if (!empty($id_list)){
            foreach($id_list as $item_id){
                $ids[]=$item_id['id'];
            }
            $result =array();
            $result['ids']=implode(',',$ids);
            print serialize($result);
        }
    }

    public function actionCloudNotReadyFull($sg=2,$ftype='video'){
        switch($ftype){
            case 'video': $likes = '((original_name LIKE "%.avi") OR (original_name LIKE "%.mkv") OR (original_name LIKE "%.mp4"))';
                break;
            default: $likes =' 1=1';
        }

        $id_list = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{catalog}}')
            ->where('(cloud_ready=0 AND sgroup = :sg) AND '.$likes,array(':sg'=>$sg))
            ->order('id DESC')
            //  ->limit(100)
            ->queryAll();
        if (empty($id_list) && $sg==2)
            $id_list = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{catalog}}')
                ->where('(cloud_ready=0 AND sgroup = :sg) AND '.$likes,array(':sg'=>6))
                ->order('id DESC')
                //->limit(100)
                ->queryAll();

        if (!empty($id_list)){
            foreach($id_list as $item_id){
                $ids[]=$item_id['id'];
            }
            $result =array();
            $result['ids']=implode(',',$ids);
            print serialize($result);
        }
    }


    public function actionCloudReady($id=0,$sg=2){
        // TO DO: hash key
        $file = CFLCatalog::model()->findByAttributes(array('id'=>$id,'sgroup'=>$sg));
        if (!$file && $sg==2)
            $file = CFLCatalog::model()->findByAttributes(array('id'=>$id,'sgroup'=>5));
        if (!$file && $sg==2)
            $file = CFLCatalog::model()->findByAttributes(array('id'=>$id,'sgroup'=>6));
        $file -> cloud_ready = 1;
        if($file->save()) echo 1;
    }
}
