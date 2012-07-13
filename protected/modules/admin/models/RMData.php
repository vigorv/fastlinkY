<?php

class RMData
{

    public static function xfieldsdataload($id)
    {

        if ($id == "")
            return false;
        $data = array();
        $xfieldsdata = explode("||", $id);
        foreach ($xfieldsdata as $xfielddata) {
            $ar = explode("|", $xfielddata);
            if (!(count($ar)>1)) continue;
            list ($xfielddataname, $xfielddatavalue) = $ar;
            $xfielddataname = str_replace("&#124;", "|", $xfielddataname);
            $xfielddataname = str_replace("__NEWL__", "\r\n", $xfielddataname);
            $xfielddatavalue = str_replace("&#124;", "|", $xfielddatavalue);
            $xfielddatavalue = str_replace("__NEWL__", "\r\n", $xfielddatavalue);
            $data[$xfielddataname] = $xfielddatavalue;
        }
        return $data;
    }

    public static function xfieldsdatasave($data)
    {
        $filecontents = "";
        $i=1;
        $count_data=count($data);
        foreach ($data as $index => $value) {
                $value= stripslashes($value);
                $value = str_replace("|", "&#124;", $value);
                $value = str_replace("\r\n", "__NEWL__", $value);
                $index2 = str_replace("|", "&#124;", $index);
                $index2 = str_replace("\r\n", "__NEWL__",$index2);
                $filecontents .= $index2.'|'.$value;
                if ($i<$count_data) $filecontents.="||";
                $i++;
            }
        return $filecontents;
    }

    public function RunImport()
    {

        set_time_limit(0);

        $db = new CDbConnection('mysql:host=nemesis.anka.ws;dbname=wsmedia2', 'watcher', 'iamremotewatcher');
        $db->charset = 'cp1251';
        $db->createCommand('SET NAMES UTF8')->execute();
        $db->active = true;

        $itable = 'rm_post';

        $command = $db->createCommand('SELECT id,title,title2,src_link, src_links,xfields,date FROM ' . $itable);
        $command->query();

        $reader = $command->query();

        $post_count = 0;
        $link_count = 0;
        $total_count = 0;
        foreach ($reader as $row) {
            $xdata = RMData::xfieldsdataload($row['xfields']);
            $links = array();
            if (isset($xdata['m_direct_links']))
                $links['v'] = $xdata['m_direct_links'];
            if (isset($xdata['music_direct_links']))
                $links['m'] = $xdata['music_direct_links'];
            if (isset($xdata['games_direct_links']))
                $links['g'] = $xdata['games_direct_links'];
            if (isset($xdata['soft_direct_links']))
                $links['s'] = $xdata['soft_direct_links'];
            foreach ($links as $key => $dir_links) {
                $link_count = 0;
                $links = array();
                preg_match_all('/(Music|Movies|Games|Software|Magazines|Music_musxq)\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);
                if($matches)
                foreach ($matches[0] as $link) {
                    //var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
                    //$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
                    $title='';
                    if (strlen($row['title'])) {
                        $title = $row['title'];
                        if (strlen($row['title2']) && (strcasecmp($row['title2'], $row['title']) <> 0))
                            $title .= '/' . $row['title2'];
                    } else if (strlen($row['title2']))
                        $title = $row['title2'];
                    $cat_item->title = filter_var($title);
                    $fname = pathinfo($name, PATHINFO_BASENAME);
                    $dir = pathinfo($name, PATHINFO_DIRNAME);
                    $cat_item->original_name = $fname;
                    $cat_item->dir = $dir;
                    $cat_item['name'] = $fname;
                    $cat_item->sgroup = 2;
                    $cat_item->dt = $row['date'];
                    $cat_item->group = $row['id'];
                    if ($cat_item->save()) {
                        $links[] = Yii::app()->createAbsoluteUrl('/catalog/file/' . $cat_item->id);
                        $link_count++;
                    }
                    else {
                        var_dump($cat_item->getErrors());
                        Echo "ERROR";
                        //die();
                    }
                }
            }
            if ($link_count) {
                unset($xdata['m_direct_links']);
                unset($xdata['games_direct_links']);
                unset($xdata['soft_direct_links']);
                unset($xdata['music_direct_links']);
                if (isset($xdata['direct_links']))
                    $xdata['direct_links'].= implode('<br />', $links);
                else
                    $xdata['direct_links'] = implode('<br />', $links);
                unset($links);
                $xdata['direct_links'] =filter_var($xdata['direct_links'], FILTER_SANITIZE_STRING);
                $xfields = RMData::xfieldsdatasave($xdata);
                $command = $db->createCommand('Update ' . $itable . ' SET xfields ="' . $xfields . '" WHERE id =' . $row['id']);
                $command->query();
                $total_count = $total_count + $link_count;
            }
            $post_count++;
        }
        echo "Processed " . $post_count . " posts. Created " . $total_count . " links";
    }

    public function ConvertZones()
    {
        $zone_list = Yii::app()->db->createCommand()
            ->select('*')
            ->from('rum_i_zones')->queryAll();
        $i = 0;
        foreach ($zone_list as $zone) {
            $range = new CFLZonesRanges();
            $range->range_ip = sprintf("%u", ip2long($zone['network']));
            $range->range_mask = $zone['mask'];
            switch ($zone['type']) {
                case 'ATLAS':
                    $range->zone_id = 7;
                    break;
                case 'HOSTEL':
                    $range->zone_id = 3;
                    break;
                case 'IPS' :
                    $range->zone_id = 8;
                    break;
                case 'OPERA-MINI':
                    $range->zone_id = 13;
                    break;
                case 'STK':
                    $range->zone_id = 1;
                    break;
                case 'STK-ALT':
                    $range->zone_id = 5;
                    break;
                case 'STK-BAR':
                    $range->zone_id = 2;
                    break;
                case 'STK-KEM':
                    $range->zone_id = 10;
                    break;
                case 'STK-IRK':
                    $range->zone_id = 14;
                    break;
                case 'STK-KRSN':
                    $range->zone_id = 11;
                    break;
                case 'STK0':
                    $range->zone_id = 6;
                    break;
                case 'TERRAPACK':
                    continue;
                    //$range->zone_id = 12;
                    //break;
            }
            if ($range->save())
                $i++;
        }
        echo "ENDED: " . $i . ' records';
    }

    public function ConvertServers()
    {
        $server_list = Yii::app()->db->createCommand()
            ->select('*')
            ->from('servers_i_rum')->queryAll();
        $i = 0;
        foreach ($server_list as $servers) {
            $server = new CFLServers();
            $ip = parse_url($servers['server'], PHP_URL_HOST);
            $server->server_ip = $ip; //sprintf('%u', ip2long($ip));
            $server->server_is_active = ($servers['active'] == 'Y');
            switch ($servers['type']) {
                case 'ATLAS':
                    $server->zone_id = 7;
                    break;
                case 'HOSTEL':
                    $server->zone_id = 3;
                    break;
                case 'IPS' :
                    $server->zone_id = 8;
                    break;
                case 'OPERA-MINI':
                    $server->zone_id = 13;
                    break;
                case 'STK':
                    $server->zone_id = 1;
                    break;
                case 'STK-ALT':
                    $server->zone_id = 5;
                    break;
                case 'STK-BAR':
                    $server->zone_id = 2;
                    break;
                case 'STK-KEM':
                    $server->zone_id = 10;
                    break;
                case 'STK-IRK':
                    $server->zone_id = 14;
                    break;
                case 'STK-KRSN':
                    $server->zone_id = 11;
                    break;
                case 'STK0':
                    $server->zone_id = 6;
                    break;
                case 'TERRAPACK':
                    continue;
                    //$server->zone_id = 12;
                    //break;
                case 'ALL':
                    $server->zone_id = 9;
                    break;
                default:
                    continue;
            }
            $server->server_group = 2;
            if ($server->save())
                $i++;
        }
        echo "ENDED: " . $i . ' records';
    }

    /**
     *
     * @return array
     */
    public function FindNewsWithoutLinks()
    {
        return Yii::app()->db->createCommand()
            ->select('rc.id,rc.title')
            ->from('{{catalog}} c')
            ->rightJoin('rum_c_cat rc', ' c.`group` = rc.id && (c.sgroup = 2 || c.sgroup = 5)')
        //     ->group('c.group')
            ->where('c.id is NULL and  !(rc.category  in (' . Yii::app()->params['news_categories_sg2'] . '))')
            ->queryAll();
    }

    /**
     *
     * @return array
     */
    public function FindLinksWithoutNews()
    {
        return Yii::app()->db->createCommand()
            ->select('c.id,c.name, c.dir, c.original_name, c.group, c.tp, c.dt, c.sz, c.sgroup')
            ->from('{{catalog}} c')
            ->leftJoin('rum_c_cat rc', ' c.group = rc.id')
            ->where('rc.id is NULL && (c.sgroup = 2 || c.sgroup = 5)')
            ->order('c.id')
            ->queryAll();
    }

    public function MakeCache(){
          $db = new CDbConnection('mysql:host=nemesis.anka.ws;dbname=wsmedia2', 'watcher', 'iamremotewatcher');
          $db->charset = 'cp1251';
          $db->createCommand('SET NAMES UTF8')->execute();
          $db->active = true;
          $count=500;
          $offset = 0;
          $totalCount = $db->createCommand('SELECT Count(`id`) FROM rm_post')->queryScalar();
          $table = 'rum_c_cat';
          Yii::app()->db->createCommand('TRUNCATE '.$table)->execute();
          while($offset<$totalCount){
            $command = $db->createCommand('SELECT id,title,title2,src_link,src_links, xfields,date,category FROM rm_post LIMIT '.$offset.','.$count);
            $ar=$command->queryAll();
              foreach ($ar as $values)
                    Yii::app()->db->createCommand()->insert($table,$values);
            $offset+=$count;
          }
    }




    public function CheckImport($id)
    {
        set_time_limit(0);

        $itable = 'rum_c_cat';

//  $db = new CDbConnection('mysql:host=localhost;dbname=rumedia', 'root', 'vig2orv115');
//        $db->charset = 'cp1251';
//        $db->active = true;
//$command = $db->createCommand('SELECT id,title2,src_link, src_links,xfields,date FROM ' . $itable);
        if ($id)
         $command = Yii::app()->db->createCommand('SELECT id,title,title2,src_link, src_links,xfields,date FROM ' . $itable . ' WHERE id =' . $id);
        else
         $command = Yii::app()->db->createCommand('SELECT id,title,title2,src_link, src_links,xfields,date FROM ' . $itable );
        $command->query();

        $reader = $command->query();

        $post_count = 0;
        $link_count = 0;
        $old_links_count=0;
        echo "<pre>";
        foreach ($reader as $row) {
            //echo "get row" . PHP_EOL;
            $xdata = RMData::xfieldsdataload($row['xfields']);
            if ($id)
                var_dump($xdata);
            $links = array();
            if (isset($xdata['m_direct_links']))
                $links['v'] = $xdata['m_direct_links'];
            if (isset($xdata['music_direct_links']))
                $links['m'] = $xdata['music_direct_links'];
            if (isset($xdata['games_direct_links']))
                $links['g'] = $xdata['games_direct_links'];
            if (isset($xdata['soft_direct_links']))
                $links['s'] = $xdata['soft_direct_links'];

            foreach ($links as $key => $dir_links) {
                preg_match_all('/(Music|Movies|Games|Software|Magazines)\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);
                if (count($matches))
                foreach ($matches[0] as $link) {
                    //var_dump($link);
                    $link_count++;
//var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
//$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
                    $title='';
                    if (strlen($row['title'])) {
                        $title = $row['title'];
                        if (strlen($row['title2']) && (strcasecmp($row['title2'], $row['title']) <> 0))
                            $title .= '/' . $row['title2'];
                    } else if (strlen($row['title2']))
                        $title = $row['title2'];
                    $cat_item->title = filter_var($title);
                    $fname = pathinfo($name, PATHINFO_BASENAME);
                    $dir = pathinfo($name, PATHINFO_DIRNAME);
                    if ($id)
                    echo"<h4> OK</h4>";
                    /* $cat_item->original_name = $fname;
                      $cat_item->dir = $dir;
                      $cat_item['name'] = $fname;
                      $cat_item->sgroup = 2;
                      $cat_item->dt = $row['date'];
                      $cat_item->group = $row['id'];
                     */
                }

                /*
                preg_match_all('/92.63.196.82\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);

                foreach ($matches[0] as $link) {

                    $link = str_replace('92.63.196.82/', '', $link);
                    //var_dump($link);
                    $link_count++;
//var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
//$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
                    $title='';
                    if (strlen($row['title'])) {
                        $title = $row['title'];
                        if (strlen($row['title2']) && (strcasecmp($row['title2'], $row['title']) <> 0))
                            $title .= '/' . $row['title2'];
                    } else if (strlen($row['title2']))
                        $title = $row['title2'];
                    $cat_item->title = filter_var($title);
                    $fname = pathinfo($name, PATHINFO_BASENAME);
                    $dir = pathinfo($name, PATHINFO_DIRNAME);

                    echo"<h4> OK</h4>";
                    /* $cat_item->original_name = $fname;
                      $cat_item->dir = $dir;
                      $cat_item['name'] = $fname;
                      $cat_item->sgroup = 2;
                      $cat_item->dt = $row['date'];
                      $cat_item->group = $row['id'];
                     */
                //}*/
// exit;
                $old_links_count++;
            }
            $post_count++;
        }
        echo "</pre>";
        echo "Processed " . $post_count . " posts. OLD_style_links ".$old_links_count.". Should Create " . $link_count . " links";
    }

}