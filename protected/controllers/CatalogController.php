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
//                $res = CFLCatalog::model()->SearchByGroup($str2, $sgroup, $gtype);
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

    public function actionViewv($id)
    {
        $this->autoload($id);
    }

    public function actionFile($id = 0, $int1 = 0)
    {
        $files = array();
        $file = array();
        if ($id > 0) {
            $file = CFLCatalog::model()->cache(1000)->findByPk($id);
            if ($file){
                if (!empty($file['group'])) {
                    $files = CFLCatalog::model()->cache(1000)->findAllByAttributes(array('group' => $file['group'], 'sgroup' => $file['sgroup']), array('order' => 'name ASC')); //order Catalog.orginal_name ASC	                               
                } else {
                    $files[0] = $file;
                }
                $this->render('file', array('files' => $files, 'file' => $file, 'autoplay' => $int1));
            }
            else
                $this->render('/elements/messages', array('msg' => Yii::t('common', 'Unknown file')));
        } else
            $this->render('/elements/messages', array('msg' => Yii::t('common', 'What u want?')));


    }

    public function actionLoad($id = 0)
    {
//$aliases = Configure::read('App.aliasUrls');
        $aliases = array('46.4.83.84', 'fastlink.ws', 'fastlink2.anka.ws');
        $r = (empty($_SERVER['HTTP_REFERER'])) ? '' : $_SERVER['HTTP_REFERER'];
        if (in_array($r, $aliases)) {
            $this->redirect('/catalog/file/' . $id);
        }
        else
            $this->autoload($id);
    }

    function autoload($id = 0)
    {
        if ($id > 0) {
            $file = CFLCatalog::model()->cache(1000)->findByPk($id);
            $letter = '';
            if ($file) {
                if ($file->sgroup == 1) {
                    $letter = strtolower($file->dir[0]);
                    if (($letter >= '0') && ($letter <= '9')) {
                        $letter = '0';
                        $file->dir = '0-999/' . $file->dir;
                    } else
                        $file->dir = $letter . '/' . $file->dir;
                }

                $servers = CFLServers::model()->getClientServers($this->zone, $file->sgroup, $letter);
                if (count($servers)) {
                    if ($this->userRole == "admin") {
                        $url_list = array();
                        foreach ($servers as $a_server) {
                            $url_list[] = 'http://' . $a_server['server_ip'] . ':' . $a_server['server_port'] . '/' . $file->dir . '/' . $file->original_name;
                        }
                        $eco_data = '<pre>';
                        $eco_data .= print_r($url_list, true);
                        $eco_data .= '</pre>';
                        echo $eco_data;
                        $this->render('/elements/messages', array('msg' => "Processed"));
                        exit();
                    }
                    $server = $servers[array_rand($servers)];
                    $catalog_clicks = CFLCatalogClicks::model()->InsertDelayed($file, $this->zone, $this->ip);
                    $url = 'http://' . $server['server_ip'] . ':' . $server['server_port'] . '/' . $file->dir . '/' . $file->original_name;
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
        //var_dump($_GET);
        if (($gid > 0) && ($sid >= 0)) {
            $criteria = new CDbCriteria();
            $criteria->condition = ' s.group = ' . $gid . ' and s.sgroup =' . $sid;
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
            $letter = '';
            if ($file['sgroup'] == 1) {
                $letter = strtolower($file['dir'][0]);
                $file['dir'] = $letter . '/' . $file['dir'];
            }
            $servers = CFLServers::model()->getClientServers($this->zone, $file['sgroup'], $letter);
            $file['link'] = array();
            foreach ($servers as $server) {
                $link = array();
                $link['url'] = 'http://' . $server['server_ip'] . '/' . $file['dir'] . '/' . $file['original_name'];
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

        // header("Content-disposition: attachment; filename=\"list.metalink\"");
        echo $out;
        exit();
        //header("Content-Type: application/xml; charset=utf-8");

//        echo $out;
    }

}
