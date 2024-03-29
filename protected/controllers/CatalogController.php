<?php

class CatalogController extends Controller
{

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return true;
    }

    public function actionSearch($search_opt, $text, $sgroup = false, $gtype = false, $ajax = 0)
    {
        $items = array();
        $i = 0;
        $pages = new CPagination();
        $pages->pageSize = Yii::app()->params['filePerPage'];
        $str2 = filter_var($text, FILTER_SANITIZE_STRING);
        $res = array();
        switch ($search_opt) {
            case 'bytitle':
//                if ($this->zone == '9') {
                $res = CFLCatalog::model()->SearchByTitleInZone($str2, $pages, 9, 0);
//                }else
//                    $res = CFLCatalog::model()->SearchByTitle($str2, $pages, 0);
                break;
            case 'bygroup':
                $res = CFLCatalog::model()->SearchByGroup($str2, $sgroup, $gtype);
                break;
        }

        foreach ($res as $r) {
            $items[$i]['url'] = Yii::app()->request->getBaseUrl(true) . '/catalog/file/' . $r['id'];
            $items[$i]['title'] = $r['title'];
            $items[$i]['filename'] = $r['original_name'];
            if ($r['original_name'] == $str2) { //ЕСЛИ ИСКАЛИ ПО ИМЕНИ ФАЙЛА
                //$items[$i]['url'] .= '?play'; //ПРИЗНАК ДЛЯ ОТОБРАЖЕНИЯ
                //$items[$i]['title'] = $r['original_name'];
            }
            $items[$i]['content'] = $r['comment'];
            $i++;
        }

        if ($ajax) {
            echo serialize($items);
            exit();
        }
        else
            $this->render('search', array('items' => $items, 'pages' => $pages, 'search_text' => $str2));
    }

    public function actionSearchAjax($search_opt, $text, $sgroup = false, $gtype = false)
    {
        $this->actionSearch($search_opt, $text, $sgroup, $gtype, 1);
    }

    public function actionViewv($id, $int1 = 0)
    {
        //$this->autoload($id);
        $this->actionFile($id, $int1);
        
    }
    //$int1 = 1 выключить autoplay
    //      = 2 вернуть картинку для ссылки для плеера
    public function actionFile($id = 0, $int1 = 0)
    {
        $files = array();
        $file = array();
        $sgroup=NULL;
        $cloud=NULL;
        if ($id > 0) {
            $file = CFLCatalog::model()->cache(1000)->findByPk($id);
            if ($file){
                if (!empty($file['group'])) {
                    $sgroup=$file['sgroup'];
                    if(in_array($file['sgroup'],array(2,5,6,7)))$sgroup=array(2,5,6,7);
                    $files = CFLCatalog::model()->cache(1000)->findAllByAttributes(array('group' => $file['group'], 'sgroup' => $sgroup), array('order' => 'name ASC')); //order Catalog.orginal_name ASC
                } else {
                    $files[0] = $file;
               }
            if($int1==2)
            {
                    $this->render('pict', array('file' => $file));
            }
	        if($file['sgroup']==1)
	        {
        		return $this->render('filesg1', array('files' => $files, 'file' => $file, 'autoplay' => $int1));
        		
        	}
        	if($file["cloud_ready"]==1 &&$file["cloud_state"]==0)
        	{
        	//echo "!!";
        	$cloud = CFLCatalog::model()->cache(3600)->getCloudReadyFiles($id);
    		//print_r($cloud);
        	}
            $userrole=$this->userRole;
            //file_put_contents("/1.txt","userRole1: ".$userrole);
        	$this->render('file', array('files' => $files, 'file' => $file,'cloud' => $cloud,'userrole'=>$userrole, 'autoplay' => $int1));
            }
            else
            {
                if($int1==2)$this->render('pict');


                $this->render('/elements/messages', array('msg' => Yii::t('common', 'Unknown file')));
            }
        } else
            $this->render('/elements/messages', array('msg' => Yii::t('common', 'What u want?')));


    }

    public function actionLoad($id = 0,$key="")
    {
//$aliases = Configure::read('App.aliasUrls');
        $aliases = array('46.4.83.84', 'fastlink.ws', 'fastlink2.anka.ws');
        $r = (empty($_SERVER['HTTP_REFERER'])) ? '' : $_SERVER['HTTP_REFERER'];
        if (in_array($r, $aliases)) {
            $this->redirect('/catalog/file/' . $id);
        }
        else
            $this->autoload($id,$key);
    }
    function ActionAdminload($id=0)
    {
    }

    function autoload($id = 0,$key="")
    {
        if ($id > 0) {

            $file = CFLCatalog::model()->cache(1000)->findByPk($id);
            $letter = '';
            if ($file) {
                $file->preset =='unknown'? $preset_str='': $preset_str =$file->preset;

                CFLCatalogClicks::model()->InsertDelayed2($file, $this->zone, $this->ip);
                if ($file->sgroup == 1) {
                    $letter = strtolower($file->dir[0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file->dir = '0-999/' . $file->dir;
                    } else
                        $file->dir = $letter . '/' . $file->dir;
                }
                if (in_array(13,explode(',',$this->zone))){
                    $this->render('/elements/messages', array('msg' => Yii::t('common', 'Please disable Opera Turbo and refresh page to continue')));
                    Yii::app()->end();
                }

                $servers = CFLServers::model()->getClientServers($this->zone, $file->sgroup, $letter);

                if ($this->userRole == "admin" && $key=="admin") {

                    $eco_data = '';
                    $eco_data .= "Вы находитесь ".$this->zone;
                    $eco_data .= "<br/>Вы запросили файл ".$id;
                    $eco_data .= "<br/>Файл принадлежит группе ".$file->sgroup;
                    $eco_data .= "<br/>Имя файла ".$file->original_name;
                    $eco_data .= "<br/>Каталог ". $file->dir.'/'.$preset_str;
                    if (count($servers)) {
                        $url_list = array();
                        $eco_data .= "<br /><br />Ссылки:<br />";
                        foreach ($servers as $a_server) {

                            $url_list = 'http://' . $a_server['server_ip'] . ':' . $a_server['server_port'] . '/' . $file->dir . '/'.$preset_str.'/' . $file->original_name;
                            $eco_data .= "<i>".$url_list."<br>";
                        }
                    }else $eco_data .= "<br/><b>Сервера не найдены</b>";

                    $eco_data .= '</pre>';
                    $this->render('load', array('data'=>$eco_data));
                    exit();
                }

                if (count($servers)) {
                    $server = $servers[array_rand($servers)];
                    if (!CFLCatalogClicks::model()->CheckTime($file,$this->ip)){
                        $catalog_clicks = CFLCatalogClicks::model()->InsertDelayed($file, $this->zone, $this->ip,$server['server_id']);
                    }
                    $url = 'http://' . $server['server_ip'] . ':' . $server['server_port'] . '/' . $file->dir . '/' .$preset_str.'/'. $file->original_name;
                    $this->render('view', array('url' => $url));
                } else {
                    CFLLogFiles::FileNotAviable($id, $file->group, $file->sgroup, $this->zone, $this->ip);
                    $this->render('/elements/messages', array('msg' => Yii::t('common', 'File no longer available')));
                }
            } else {
                CFLLogFiles::FileNotExists($id, $this->zone, $this->ip);
                $this->render('/elements/messages', array('msg' => Yii::t('common', 'File not found')));
            }
        } else {
            $this->render('/elements/messages', array('msg' => Yii::t('common', 'What u want?')));
        }
    }

    public function actionMeta($gid = 0, $sid = 0, $gtype = 0)
    {
        $this->layout = '/layouts/playlist';
        $files = array();
        $sid = (int)$sid;
        if(in_array($sid,array(2,5,6,7)))$sid="2,5,6,7";
        //var_dump($_GET);
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = ' s.group = ' . $gid . ' and s.sgroup in (' . $sid.") ";
            $criteria->order = 's.name ASC';
            $criteria->alias = 's';
            //$files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => $int1), array('order' => 'original_name ASC')); //order Catalog.orginal_name ASC	                               
            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
        }

        // header("Content-Type: application/metalink+xml; charset=utf-8");
        //else
        //  $this->redirect('/catalog');
        foreach ($files as &$file) {
            $file['preset'] =='unknown'? $preset_str='': $preset_str =$file['preset'];
            $letter = '';
            if ($file['sgroup'] == 1) {
                $letter = strtolower($file['dir'][0]);
                $file['dir'] = $letter . '/' . $file['dir'];
            }
            $servers = CFLServers::model()->getClientServers($this->zone, $file['sgroup'], $letter);
            $file['link'] = array();
            foreach ($servers as $server) {
                $link = array();
                $link['url'] = 'http://' . $server['server_ip'] . '/' . $file['dir'] . '/'.$preset_str.'/'. $file['original_name'];
                $link['type'] = 'http';
                $link['location'] = 'ru';
                $link['prio'] = 100;
                $file['link'][] = $link;
            }
        }

        // header('Content-Type: application/metalink+xml');
        $this->layout = '/layouts/playlist';
        $out = $this->renderPartial('/elements/filelist', array('files' => $files), true);
        header("Content-Type: application/metalink+xml; charset=utf-8");
        header("Content-Length: " . strlen($out));
        header("Content-disposition: attachment; filename=\"list.metalink\"");
        echo $out;
        exit();
        //header("Content-Type: application/xml; charset=utf-8");

//        echo $out;
    }

    //
    public function actionPlaylist($gid = 0, $sid = 0, $gtype = 0)
    {
        $this->layout = '/layouts/playlist';
        $files = array();
        $sid = (int)$sid;
        //var_dump($_GET);
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = 's.cloud_ready=1 and s.cloud_state=0 and s.group = ' . $gid . ' and s.sgroup =' . $sid;
            $criteria->order = 's.name ASC';
            $criteria->alias = 's';
            //$files = CFLCatalog::model()->cache(10)->findAllByAttributes(array('group' => $id, 'sgroup' => $int1), array('order' => 'original_name ASC')); //order Catalog.orginal_name ASC
            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
        }

        foreach ($files as &$file) {
            $file['preset'] =='unknown'? $preset_str='': $preset_str =$file['preset'];
            $letter = '';
            if ($file['sgroup'] == 1) {
                $letter = strtolower($file['dir'][0]);
                $file['dir'] = $letter . '/' . $file['dir'];
            }
            $file['cloud'] = CFLCatalog::model()->cache(3600)->getCloudReadyFiles($file['id']);
        }
        $this->layout = '/layouts/playlist';
        $out = $this->renderPartial('/elements/playlist', array('files' => $files), true);
        echo $out;
        exit();
    }
    public function actionGetLastFileCloudReady($gid = 0, $sid = 0, $gtype = 0,$client_ip=NULL)
    {
        $this->layout = '/layouts/playlist';
        $files = array();
        $sid = (int)$sid;
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = 's.cloud_ready=1 and s.cloud_state=0 and s.group = ' . $gid . ' and s.sgroup =' . $sid;

            $criteria->order = 's.id DESC';
            $criteria->alias = 's';
            $criteria->limit = 1;
            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
        }
        $out=array();
        //$out['cdn1']=Yii::app()->params['UppodServer'];
        if($client_ip){

            $this->zone = CFLZones::model()->getActiveZoneslst($client_ip);
        }
        $out['cdn1'] = CFLServers::model()->getClientServerString($this->zone,10,"");
            foreach ($files as &$file) {
            $file['preset'] =='unknown'? $preset_str='': $preset_str =$file['preset'];
            $letter = '';
            if ($file['sgroup'] == 1) {
                $letter = strtolower($file['dir'][0]);
                $file['dir'] = $letter . '/' . $file['dir'];
            }
            $file['cloud'] = CFLCatalog::model()->cache(3600)->getCloudReadyFiles($file['id']);
            $name=pathinfo($file['title'],PATHINFO_FILENAME);
            $out['name']=str_replace("_"," ",$name);
            foreach($file['cloud'] as $v)$out['cloud_files'][$v['id']]=$v['fpath'];

        $this->layout = '/layouts/playlist';
        $i=0;
        $count=count($files);
        $out = serialize($out);//$this->renderPartial('/elements/playfile', array('files' => $files), true);
        echo $out;
        exit();
        }
    }


//
    public function actionGetGroupCloudReady($gid = 0, $sid = 0, $gtype = 0)
    {
        $this->layout = '/layouts/playlist';
        $files = array();
        $sid = (int)$sid;
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = 's.cloud_ready=1 and s.cloud_state=0 and s.group = ' . $gid . ' and s.sgroup =' . $sid;
            $criteria->alias = 's';
            echo CFLCatalog::model()->count($criteria);
        }
        exit();
    }




    public function actionUser(){
        if (Yii::app()->user->id){

            $per_page = 20;

            $criteria = new CDbCriteria();
         //   $criteria->select = 's.id,s.name';
            $criteria->condition = 'user_id='.Yii::app()->user->id;
            $criteria->order = 's.name ASC';
            $criteria->alias = 's';

            $count = CFLCatalog::model()->count($criteria);

            $pages = new CPagination($count);
            $pages->pageSize = $per_page;
            $pages->applyLimit($criteria);

            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
            $this->render('user',array('list' => $files,'pages' => $pages));
        } else{
            echo Yii::t('common',"You are not registred");
        }
    }

    public function actionFileGroup($id=0){
        if (in_array($this->userRole,array('admin','moderator'))) {

            $per_page = 20;

            $criteria = new CDbCriteria();
            //   $criteria->select = 's.id,s.name';
            $criteria->condition = ' ((s.group = '.$id .') AND (s.sgroup=2)) OR ((s.group = '.$id .') AND (s.sgroup=6))';
            $criteria->order = 's.name ASC';
            $criteria->alias = 's';

            $count = CFLCatalog::model()->count($criteria);

            $pages = new CPagination($count);
            $pages->pageSize = $per_page;
            $pages->applyLimit($criteria);

            $files = CFLCatalog::model()->getCommandBuilder()
                ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
                ->queryAll();
            $this->render('user',array('list' => $files,'pages' => $pages));
        }
         else $this->redirect('/users/login');
    }



    public function actionDeleteFiles(){
        if (Yii::app()->user->id){
            if (isset($_POST['ids'])){
                $fid =  $_POST['ids'];
                if (count($fid)>30) exit;
                $ids = implode(",", $fid);
                $ids = filter_var($ids,FILTER_SANITIZE_STRING);
                if($ids){
                    if (in_array($this->userRole,array('admin','moderator'))) {
                        $files = CFLCatalog::model()->findAll('id in ('.$ids.')');
                    } else
                        $files = CFLCatalog::model()->findAll('id in ('.$ids.') AND user_id = '.Yii::app()->user->id);
                    $dcount=0;
                    /** @var CFLCatalog $file */
                    foreach ($files as $file){
                        $server2 = false;
                        switch ($file->sgroup){
                            case 2:
                                    $server = Yii::app()->params['uploadServer_sg2'];
                                    $server2 = Yii::app()->params['uploadServerA_sg2']; break;
                            case 4: $server = Yii::app()->params['uploadServer'];break;
                            case 6:
                            default: echo "not there ".$file->sgroup; Yii::app()->end();
                        }
                        ($file->preset =='unknown') ? $preset_str='': $preset_str =$file->preset;
                        if (defined('YII_DEBUG')&& YII_DEBUG)
                            echo $file->dir.'/'.$preset_str.'/'.$file->original_name.'<br/>';
                        $data=base64_encode($file->dir . '/' .$preset_str.'/'. $file->original_name);
                        $skey=md5($data.Yii::app()->params['master_key']);


                        $query = http_build_query(array('data'=>$data,'key'=>$skey));
                        $context = stream_context_create(array(
                            'http' => array(
                                'method' => 'POST',
                                'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
                                'content' => $query,
                            ),
                        ));

                        $url = 'http://' . $server. '/files/delete';
                        // echo $url;
                        // flush();

                        $result = file_get_contents($url, $use_include_path=false, $context);

                        //$url = 'http://' . $server. '/files/delete?data='.$data.'&key='.$skey;
                        //$result = file_get_contents($url);
                        $result2="OK";
                        if ($server2) {
                            $url = 'http://' . $server2. '/files/delete';
                            $result2 = file_get_contents($url, $use_include_path=false, $context);
                        }
                        if ($result=="OK" && $result2=="OK"){
                            $file->delete();
                            $dcount++;
                        } else {
                            if (defined('YII_DEBUG') && YII_DEBUG)
                              echo $result.' '.$result2.'<br/>';
                        }
                    }
                    echo "Deleted $dcount";
                    Yii::app()->end();
                } else die('not list');
            } else die('nothing');
        } else
            die('unknown');
    }

    public function actionLink($id=0){
        $id=(int)$id;
        if ($id>0){
            $file = CFLCatalog::model()->cache(100)->findByPk($id);
            $msg='<p>'.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.'</p> <p> BBCODE: <br/>[url='.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.']'.$file['name'].'[/url] </p>';
            $this->render('/elements/messages', array('msg' =>$msg));
        } elseif (isset($_GET['id_list'])){
            $id_list = explode('_',$_GET['id_list']);
            $msg ='';
            $msg2 = '';
            foreach ($id_list as $id){
                $file = CFLCatalog::model()->cache(100)->findByPk($id);
                $msg.='<p>'.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.'</p>';
                $msg2.='<p>[url='.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.']'.$file['name'].'[/url] </p>';
            }
            $this->render('/elements/messages', array('msg' =>$msg.' BBCODE: <br/>'.$msg2));
        }

    }


   public function actionGroupLinks($id=0,$group_id=0){
       $id=(int)$id;
       if ($id>0){
           $files = CFLCatalog::model()->cache(100)->findAllByAttributes(array('group'=>$id,'sgroup'=>$group_id),array('order'=>'id'));
           $msg_links='';
           $msg_bbcode='BBCODE:';
           foreach ($files as $file){
               $msg_links.=''.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$file['id'].'</br>';
               $msg_bbcode.='[url='.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$file['id'].']'.$file['name'].'[/url] <br/> ';
            }
           $this->render('/elements/messages', array('msg' =>$msg_links.$msg_bbcode));
       }
   }

    public function actionGroupLinksByName($name='',$group_id=0,$order='name'){
        if (strlen($name)){
            $name = filter_var($name,FILTER_SANITIZE_STRING);
            $order = filter_var($order,FILTER_SANITIZE_STRING);
            $criteria = new CDbCriteria();
            $criteria->select='*';
            $criteria->condition='(name LIKE "%'.$name.'%") AND (sgroup='.(int)$group_id.')';
            $criteria->order=$order;
            $files = CFLCatalog::model()->cache(100)->findAll($criteria);
            $msg_links='';
            $msg_bbcode='<p>BBCODE:</p>';
            foreach ($files as $file){
                $msg_links.=''.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$file['id'].'<br/>';
                $msg_bbcode.=' [url='.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$file['id'].']'.$file['name'].'[/url]<br/>';
            }
            $this->render('/elements/messages', array('msg' =>'<div style="word-wrap:break-word">'.$msg_links.$msg_bbcode.'</div>'));
        }
    }

    public function actionLinks($ids=false){
        if ($ids){
            $id_list=@unserialize(@base64_encode($ids));
            if (is_array($id_list)){
                foreach($id_list as $id){
                    $file = CFLCatalog::model()->cache(1000)->findByPk($id);
                    echo '<p>'.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.'</p> <p> BBCODE: <br/>[url='.Yii::app()->createAbsoluteUrl('catalog/viewv').'/'.$id.']'.$file['name'].'[/url] </p>';
                }
            }

        }
    }

    public function actionItemData($id=false){
        if ($id){
            $file = CFLCatalog::model()->cache(1000)->findByPk($id);
            echo serialize($file['name']);
        }
    }

}
