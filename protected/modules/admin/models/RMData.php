<?php

class RMData {

    public static function xfieldsdataload($id) {

        if ($id == "")
            return;

        $xfieldsdata = explode("||", $id);
        foreach ($xfieldsdata as $xfielddata) {
            list ( $xfielddataname, $xfielddatavalue ) = explode("|", $xfielddata);
            $xfielddataname = str_replace("&#124;", "|", $xfielddataname);
            $xfielddataname = str_replace("__NEWL__", "\r\n", $xfielddataname);
            $xfielddatavalue = str_replace("&#124;", "|", $xfielddatavalue);
            $xfielddatavalue = str_replace("__NEWL__", "\r\n", $xfielddatavalue);
            $data[$xfielddataname] = $xfielddatavalue;
        }
        return $data;
    }

    public function RunImport() {

        set_time_limit(0);

        $itable = 'rum_i_cat';

        $command = Yii::app()->db->createCommand('SELECT id,title,title2,src_link, src_links,xfields,date FROM ' . $itable);
        $command->query();

        $reader = $command->query();

        $post_count = 0;
        $link_count = 0;

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
                preg_match_all('/(Music|Movies|Games|Software)\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);
                foreach ($matches[0] as $link) {
//var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
                    //$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
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
                    if ($cat_item->save())
                        $link_count++;
                    else {
                        var_dump($cat_item->getErrors());
                        Echo "ERROR";
                        //die();
                    }
                }
// exit;
            }
            $post_count++;
        }
        echo "Processed " . $post_count . " posts. Created " . $link_count . " links";
    }

    public function ConvertZones() {
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
                    $range->zone_id = 12;
                    break;
            }
            if ($range->save())
                $i++;
        }
        echo "ENDED: " . $i . ' records';
    }

    public function ConvertServers() {
        $server_list = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('servers_i_rum')->queryAll();
        $i = 0;
        foreach ($server_list as $servers) {
            $server = new CFLServers();
            $ip = parse_url($servers['server'], PHP_URL_HOST);
            $server->server_ip = $ip;//sprintf('%u', ip2long($ip));
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
                    $server->zone_id = 12;
                    break;
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
     * @return type 
     */
    public function FindNewsWithoutLinks() {
        return Yii::app()->db->createCommand()
                        ->select('rc.id')
                        ->from('{{catalog}} c')
                        ->rightJoin('rum_i_cat rc', ' c.`group` = rc.id && c.sgroup = 2')
                        //     ->group('c.group')
                        ->where('c.id is NULL and  !(rc.category  in ('.Yii::app()->params['news_categories_sg2'].'))')
                        ->queryAll();
    }

    /**
     *
     * @return type 
     */
    public function FindLinksWithoutNews() {
        return Yii::app()->db->createCommand()
                        ->select('c.id')
                        ->from('{{catalog}} c')
                        ->leftJoin('rum_i_cat rc', ' c.group = rc.id')
                        ->where('rc.id is NULL && c.sgroup = 2')
                        ->queryAll();
    }

    public function CheckImport($id) {
        set_time_limit(0);

        $itable = 'rum_i_cat';

//  $db = new CDbConnection('mysql:host=localhost;dbname=rumedia', 'root', 'vig2orv115');
//        $db->charset = 'cp1251';
//        $db->active = true;
//$command = $db->createCommand('SELECT id,title2,src_link, src_links,xfields,date FROM ' . $itable);
        $command = Yii::app()->db->createCommand('SELECT id,title,title2,src_link, src_links,xfields,date FROM ' . $itable . ' WHERE id =' . $id);
        $command->query();

        $reader = $command->query();

        $post_count = 0;
        $link_count = 0;
        foreach ($reader as $row) {
            echo "get row" . PHP_EOL;
            $xdata = RMData::xfieldsdataload($row['xfields']);
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
                preg_match_all('/(Music|Movies|Games|Software)\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);
                foreach ($matches[0] as $link) {
                    var_dump($link);
                    $link_count++;
//var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
//$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
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
                }
                preg_match_all('/92.63.196.82\/[\w\.\(\)\-\/\&]+/', $dir_links, $matches);

                foreach ($matches[0] as $link) {
                    
                    $link=str_replace('92.63.196.82/', '',$link);
                    var_dump($link);
                    $link_count++;
//var_dump($link);continue;
//   $name = parse_url($link[0], PHP_URL_PATH);
                    $name = $link;
                    $cat_item = new CFLCatalog();
                    $cat_item->is_confirm = 1;
                    $cat_item->is_visible = 1;
//$cat_item->title = iconv('cp1251', 'UTF-8', $row['title2']);
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
                }



// exit;
            }
            $post_count++;
        }
        echo "Processed " . $post_count . " posts.Should Create " . $link_count . " links";
    }

}