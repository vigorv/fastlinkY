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

    public function actionCheckLinksWithNoNews()
    {
        $rmdata = new RMData();
        $data = $rmdata->FindLinksWithoutNews();
        $this->render('cataloglist', array('data' => $data));
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