<?php

class UtilsController extends AdmController
{

    public function actionIndex()
    {
        $this->render('index');
    }


    public function actionMakeCache()
    {
        $rmdata = new RMData();
        $rmdata->makeCache();
        $this->render('/elements/messages', array('msg' => 'makeCache'));
    }

    public function actionCheckNewsWithNoLinks()
    {
        $rmdata = new RMData();
        $data = $rmdata->FindNewsWithoutLinks();
        $this->render('list2', array('data' => $data));
    }

    public function actionCheckLinksWithNoNews($sgroup=NULL)
    {
        $rmdata = new RMData();
        echo "sgroup=".$sgroup."<br />";
        $data = $rmdata->FindLinksWithoutNews($sgroup);
        $this->render('cataloglist', array('data' => $data));
    }

    public function actionCheckLinksWithoutNewsAll()
    {
        $rmdata = new RMData();
        $rmdata->makeCache();
        $data = $rmdata->FindLinksWithoutNewsAll();
        //$this->render('cataloglist', array('data' => $data));
    }



    public function actionShowItemsWithNoFiles($sgroup = 2)
    {
        echo 'removed';
        exit();
        set_time_limit(0);
        $files = Yii::app()->db->createCommand("Select * from fl_catalog where sgroup = " . (int)$sgroup)->query();
        $items = array();
        while ($file = $files->read()) {
            switch ($file['sgroup']) {
                case 2:
                    $server = Yii::app()->params['uploadServer_sg2'];
                    break;
                case 4:
                    $server = Yii::app()->params['uploadServer'];
                    break;
                default:
                    echo "not there " . $file['sgroup'];
                    Yii::app()->end();
            }
            $file['preset'] =='unknown'? $preset_str='': $preset_str =$file['preset'];
            $data = base64_encode($file['dir'] . '/' .$preset_str.'/' . $file['original_name']);
            $skey = md5($data . Yii::app()->params['master_key']);
            $url = 'http://' . $server . '/files/checkexists?data=' . $data . '&key=' . $skey;
            $data = file_get_contents($url);
            if ($data == "BAD") {
                echo  $file->id. ' : '.$file['dir'] . '/' .$preset_str.'/'. $file['original_name'].'<br/>';
                flush();
            }
        }
    }

    public function actionLinkData(){
        set_time_limit(3000);
        $rmdata = new RMData();
        $rmdata->makeCache();
        $date = date("Y-m-d H:i:s",strtotime('-1 hour'));
        $catalog = CFLCatalog::model()->findAll('`group` = 0 AND sgroup = 2 AND dt<=:date',array(':date'=>$date));
        foreach ($catalog as $item){
           $news_id = Yii::app()->db->createCommand("SELECT id FROM `rum_c_cat` WHERE `xfields` LIKE '%/catalog/viewv/".$item['id']."%'")->queryScalar();
           if($news_id){
               echo "SET group ".$news_id." for link ".$item['id']."<br/>";
               Yii::app()->db->createCommand('UPDATE fl_catalog set `group`=:group WHERE id =:item_id')->bindValues(array(':group'=>$news_id,':item_id'=>$item['id']))->execute();
               } else {
                   echo "not found for link ".$item['id']."<br>";
               }
           }
        }
    public function actionUnLinkData(){
        set_time_limit(3000);
        $rmdata = new RMData();
        $rmdata->makeCache();
        $date = date("Y-m-d H:i:s",strtotime('-1 day'));
        $i=0;
        $catalog = CFLCatalog::model()->findAll('`group` <> 0 AND `sgroup` in (2,5,6) AND dt<=:date order by id desc ',array(':date'=>$date));
        file_put_contents("/1.txt","start:"."\n");
        foreach ($catalog as $item){
            $i++;
            if($i%500)file_put_contents("/1.txt","..".$i."\n",FILE_APPEND);
            $news_id = Yii::app()->db->createCommand("SELECT id FROM `rum_c_cat` WHERE `xfields` LIKE '%/catalog/viewv/".$item['id']."%'")->queryScalar();
            if($news_id){
                echo "+ found news for link ".$item['id']."<br>\n";
                //echo "SET group ".$news_id." for link ".$item['id']."<br/>";
            } else {
                echo "-not found news for link ".$item['id']."<br>\n";
                file_put_contents("/1.txt",$item['id']."\n",FILE_APPEND);
                Yii::app()->db->createCommand('UPDATE `fl_catalog` set `group`=0 WHERE id =:item_id')->bindValues(array(':item_id'=>$item['id']))->execute();
            }
        }
        echo "\n done<br>";
        file_put_contents("/1.txt","..done\n",FILE_APPEND);
    }

    public function actionLinkDataOrKill(){
        set_time_limit(3000);
        $rmdata = new RMData();
        $rmdata->makeCache();
        $date = date("Y-m-d H:i:s",strtotime('-1 week'));
        $catalog = CFLCatalog::model()->findAll('`group` = 0 AND sgroup in (2,5,6,7) AND dt<=:date',array(':date'=>$date));
        foreach ($catalog as $item){
           $news_id = Yii::app()->db->createCommand("SELECT id FROM `rum_c_cat` WHERE `xfields` LIKE '%/catalog/viewv/".$item['id']."%'")->queryScalar();
           if($news_id){
               echo "SET group ".$news_id." for link ".$item['id']."<br/>\n";
               Yii::app()->db->createCommand('UPDATE fl_catalog set `group`=:group WHERE id =:item_id')->bindValues(array(':group'=>$news_id,':item_id'=>$item['id']))->execute();
           } else {
               echo "DELETE link ".$item['id']." cause no link<br/>\n";
               $model = CFLCatalog::model()->findByPk($item['id']);
               $url=false;
               if ($model){
                   $model->preset =='unknown'? $preset_str='': $preset_str =$model->preset;
                   $data = base64_encode($model->dir . '/' .$preset_str.'/'. $model->original_name);
                   //echo Yii::app()->params['master_key'];
                   if (defined('YII_DEBUG') && YII_DEBUG)
                       echo $model->dir.'/'.$preset_str.'/'.$model->original_name;
                   $sdata = md5($data.Yii::app()->params['master_key']);
                   $urls = array();
                   switch($model->sgroup){
                       case 2:
                           $urls[] = 'http://'. Yii::app()->params['uploadServer_sg2'].'/files/delete';
                           $urls[] = 'http://'. Yii::app()->params['uploadServerA_sg2'].'/files/delete';
                           break;
                       case 4:
                           $urls[] = 'http://'. Yii::app()->params['uploadServer'].'/files/delete';
                           break;
                       case 0:
                           $model->deleteByPk($item['id']);
                           echo 'Deleted<br>';
                           return;
                           break;
                       case 6:
                       case 5:
                           // TODO: delete from group5
                           $urls[] = 'http://'. Yii::app()->params['group5_server'].'/files/delete';
                       case 7:
                           // TODO: delete from group5
                           $urls[] = 'http://'. Yii::app()->params['group7_server'].'/files/delete';
                       default:
                   }
                   $res=array();
                   foreach($urls as $url){
                       $res[]=@file_get_contents($url.'?data='.$data.'&key='.$sdata);
                   }
                   if ((count($res)==1 && $res[0]=="OK") || (count($res)>1 && $res[0]=="OK" && $res[1]=="OK" )){
                       $model->deleteByPk($item['id']);
                       echo 'Deleted<br>/n';
                   } else{
                       echo "Can't delete\n";
                       if (defined('YII_DEBUG') && YII_DEBUG){
                           var_dump($urls);
                           echo '?data='.$data.'&key='.$sdata;
                       }
                   }
               } else {
                   echo "not found\n";
               }
               //Yii::app()->db->createCommand('DELETE FROM fl_catalog  WHERE id =:item_id',array(':item_id'=>$item['id']));
           }
        }
        if (!count($catalog)) echo "No items found\n";
    }


    public function actionLinkEmpties()
    {
        $rmdata = new RMData();
        $rdata = $rmdata->FindNewsWithoutLinks();
        foreach ($rdata as $item) {
            $xfields = RMData::xfieldsdataload($item['xfields']);
            if (isset($xfields['direct_links'])) {
                $dlinks_data = $xfields['direct_links'];
                $dlinks_data = str_replace('<br />', PHP_EOL, $dlinks_data);
                $dlinks_data = str_replace('<br>', PHP_EOL, $dlinks_data);
                preg_match_all("/catalog\/viewv\/[0-9]+/", $dlinks_data, $data);
                $ids = array();
                foreach ($data as &$matches)
                    foreach ($matches as &$str)
                        $ids[] = substr($str, 14);
                array_unique($ids, SORT_NUMERIC);
                foreach ($ids as $id) {
                    $catalog = CFLCatalog::model()->findByAttributes(array('group' => 0, 'sgroup' => 2, 'id' => $id));
                    if ($catalog) {
                        $catalog->group = $item['id'];
                        $catalog->save();
                        echo "<p>Set $catalog->group for $id </p>";
                    }
                }
            }
        }
    }

    public function actionSetFileListToGroup($filename = '', $group_id = 0)
    {
        if (!$group_id) return;
        $filename = FILTER_VAR($filename);
        $lines = file('/var/data/' . $filename);
        //   var_dump($lines);
        set_time_limit(0);

        foreach ($lines as $fpath) {
            $directory = pathinfo($fpath, PATHINFO_DIRNAME);
            $directory = filter_var(substr($directory, 2, strlen($directory) - 2),FILTER_SANITIZE_STRING);
            $fname = trim(filter_var(pathinfo($fpath, PATHINFO_BASENAME),FILTER_SANITIZE_STRING));

            //var_dump($data);
            $query= "SELECT id FROM fl_catalog WHERE `dir` = '$directory' and `name`='$fname'";
            echo $query.'<br/>';
            $catalog_id = Yii::app()->db->
                createCommand($query)->queryScalar();
            /* @var CFLCatalog $catalog */
            if ($catalog_id) {
                $query = "UPDATE fl_catalog SET `sgroup`= $group_id WHERE `id` = $catalog_id";
                echo $query.'<br/>';
                Yii::app()->db->createCommand($query)->execute();
            }
            flush();
        }
    }


    public function actionCheckI($id = 0)
    {
        $rmdata = new RMData();
        $rmdata->CheckImport($id);
        $this->render('index');
    }

}