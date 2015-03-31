<?php

class ApiController extends Controller
{
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return true;
    }

    public function actionFileGroup($id = 0, $sg = 2)
    {
        if ($id > 0) {
            $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => $sg));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => 6));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => 5));
            if (!empty($files)) {
                $data = array('group' => $id, 'count' => count($files));
                foreach ($files as $f)
                    $data['files'][] = $f['id'];
                echo serialize($data);
            }
        }
    }

    public function actionGroupOfFile($id = 0)
    {
        if ($id > 0) {
            $file = CFLCatalog::model()->cache(100)->findByPk($id);
            if ($file) {
                $files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $file->group, 'sgroup' => $file->sgroup));
                /** @var CFLCatalog $file */
                if (!empty($files)) {
                    $data = array('group' => $file->group, 'count' => count($files));
                    foreach ($files as $f)
                        $data['files'][] = $f['id'];
                    echo serialize($data);
                } else
                echo serialize(array('error'=>1));
            } else
                echo serialize(array('error'=>1));
        }
    }

    public function actionFilePath($item_id = 0)
    {
        if ($item_id > 0) {
            $file = CFLCatalog::model()->cache(1000)->findByPk($item_id);
            /** @var CFLCatalog $file */
            if ($file) {
                if ($file->sgroup == 1) {
                    $letter = strtolower($file->dir[0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file->dir = '0-999/' . $file->dir;
                    } else
                        $file->dir = $letter . '/' . $file->dir;
                }
                $files = array($file->dir . '/' . $file->name);
                echo serialize($files);
            }
        }
    }

    public function actionFileGroupPath($item_id = 0, $sg = 2)
    {
        if ($item_id > 0) {
            $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group' => $item_id, 'sgroup' => $sg), array('order' => 'id'));
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group' => $item_id, 'sgroup' => 5), array('order' => 'id'));
            ;
            if (empty($files) && $sg == 2)
                $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group' => $item_id, 'sgroup' => 6), array('order' => 'id'));
            ;
            $res = array();
            foreach ($files as $file) {
                if ($file['sgroup'] == 1) {
                    $letter = strtolower($file['dir'][0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file['dir'] = '0-999/' . $file['dir'];
                    } else
                        $file['dir'] = $letter . '/' . $file['dir'];
                }
                $res[] = $file['dir'] . '/' . $file['name'];
            }
            echo serialize($res);
        }
    }

    public function actionCloudNotReady($sg = 2, $ftype = 'video',$limit=10)
    {
        switch ($ftype) {
            case 'video':
                $likes = '((original_name LIKE "%.avi") OR (original_name LIKE "%.mkv") OR (original_name LIKE "%.mp4")) AND `group`<>0 AND dt >DATE_SUB(CURDATE(),INTERVAL 30 DAY)';
                break;
            default:
                $likes = ' 1=1';
        }

        $id_list = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{catalog}}')
            ->where('(cloud_ready=0 AND sgroup = :sg) AND ' . $likes, array(':sg' => $sg))
            ->order('id DESC')
            ->limit($limit)
            ->queryAll();
        if (empty($id_list) && $sg == 2)
            $id_list = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{catalog}}')
                ->where('(cloud_ready=0 AND sgroup = :sg) AND ' . $likes, array(':sg' => 6))
                ->order('id DESC')
                ->limit($limit)
                ->queryAll();

        if (!empty($id_list)) {
            foreach ($id_list as $item_id) {
                $ids[] = $item_id['id'];
            }
            $result = array();
            $result['ids'] = implode(',', $ids);
            print serialize($result);
        }
    }

    public function actionCloudNotReadyFull($sg = 2, $ftype = 'video')
    {
        switch ($ftype) {
            case 'video':
                $likes = '((original_name LIKE "%.avi") OR (original_name LIKE "%.mkv") OR (original_name LIKE "%.mp4"))';
                break;
            default:
                $likes = ' 1=1';
        }

        $id_list = Yii::app()->db->createCommand()
            ->select('id')
            ->from('{{catalog}}')
            ->where('(cloud_ready=0 AND sgroup = :sg) AND ' . $likes, array(':sg' => $sg))
            ->order('id DESC')
        //  ->limit(100)
            ->queryAll();
        if (empty($id_list) && $sg == 2)
            $id_list = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{catalog}}')
                ->where('(cloud_ready=0 AND sgroup = :sg) AND ' . $likes, array(':sg' => 6))
                ->order('id DESC')
            //->limit(100)
                ->queryAll();

        if (!empty($id_list)) {
            foreach ($id_list as $item_id) {
                $ids[] = $item_id['id'];
            }
            $result = array();
            $result['ids'] = implode(',', $ids);
            print serialize($result);
        }
    }


    public function actionCloudReady($id = 0)
    {
        // TO DO: hash key
        $file = CFLCatalog::model()->findByAttributes(array('id' => $id));
        $file->cloud_ready = 1;
        $file->cloud_state = 0;
        if ($file->save()) echo 1;
    }

    public function actionCloudFail($id = 0,$cmd_id=0)
    {
        // TO DO: hash key
        $file = CFLCatalog::model()->findByAttributes(array('id' => $id));
        $file->cloud_ready =50;
        $file->cloud_state =$cmd_id;
        if ($file->save()) echo 1;
    }


    //определяет самый популярный контент для категории контента входящий в опредленный обьем данных
    public function actionGetSpeed($sgroup,$sizelimit=4,$debug=0)
    {   
        $LIMIT=$sizelimit*1000*1024*1024;
        $top30=CFLCatalogClicks::model()->cache(5*60)->GetTOP20($sgroup);
        $links=array();
        $sz=0;
        foreach ($top30 as $row) {
            $id=$row['catalog_id'];
            $result2 = Yii::app()->db->createCommand()
                ->select('id,dir,original_name,sz')
                ->from('{{catalog}}')
                ->where('id=:id AND sz < :sz', array(':id'=>$id,':sz' => $LIMIT))
                ->limit (1)
                ->queryAll();
            foreach($result2 as $row2)
            {
               if(($sz+$row2['sz'])>$LIMIT){continue;}
                $sz+=$row2['sz'];
                $links[$row2['id']]['dir']=$row2['dir'];
                $links[$row2['id']]['size']=$row2['sz'];
                $links[$row2['id']]['name']=$row2['original_name'];
                $links[$row2['id']]['count']=$row['count'];
            }
    }
    if($debug==1)
    {
        $this->render('getspeed', array('links' => $links,'sz'=>$sz,'limit'=>$LIMIT));
    }
    else {
        $this->layout="ajax";
        $this->render('getspeedajax', array('links' => $links));
    }

    //Yii::app()->exit();
   }

    public function actionSgroupFiles($gid = 0, $sid = 0,$client_ip)
    {
        //$this->layout = '/layouts/playlist';
        $files = array();$files2=array();
        $sid = (int)$sid;
        //var_dump($_GET);
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->select="id,title,dir,preset,sgroup";
            $criteria->condition = 's.cloud_ready=1 and s.cloud_state=0 and s.group = ' . $gid . ' and s.sgroup =' . $sid;
            $criteria->order = 's.name ASC';
            $criteria->alias = 's';
            //$files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => $int1), array('order' => 'original_name ASC')); //order Catalog.orginal_name ASC
            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
           // var_dump($files);
        }
        $this->zone = CFLZones::model()->getActiveZoneslst($client_ip);
        foreach ($files as &$file) {
            $file['preset'] =='unknown'? $preset_str='': $preset_str =$file['preset'];
            $letter = '';
            if ($file['sgroup'] == 1) {
                $letter = strtolower($file['dir'][0]);
                $file['dir'] = $letter . '/' . $file['dir'];
            }
            $file['cloud'] = CFLCatalog::model()->cache(3600)->getCloudReadyFiles($file['id']);
            $file['server'] = CFLServers::model()->getClientServerString($this->zone,10,"");
            $file['name']=pathinfo($file['title'],PATHINFO_FILENAME);
            $file['name']=str_replace("_"," ",$file['name']);
            //var_dump($file);
            $files2[]=$file;
        }
        echo base64_encode(serialize($files2));
        //$this->layout = '/layouts/playlist';
        //$out = $this->renderPartial('/elements/playlist', array('files' => $files), true);
        exit();
    }

}
