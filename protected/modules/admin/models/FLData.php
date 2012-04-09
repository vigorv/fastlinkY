<?php

class FLData {

    public function RunImport() {
        set_time_limit(0);
        Yii::app()->db->createCommand('insert into fl_catalog select * from zfl_i_cat')->execute();
        Yii::app()->db->createCommand('UPDATE fl_catalog SET sgroup = 1 WHERE sgroup = 0 AND group<>0')->execute();


        echo "ENDED";
    }

    public function ConvertServers() {
        $server_list = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('zfl_i_servers')->queryAll();
        $i = 0;
        foreach ($server_list as $servers) {
            $server = new CFLServers();
            $server->server_ip = $server['addr'];//sprintf("%u", ip2long($servers['addr']));
            $server->server_is_active = $servers['is_active'];
            $server->server_letter = $servers['letter'];
            switch ($servers['zone']) {
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
                case 'NSK':
                    $server->zone_id = 1;
                    break;
                case 'STKALT':
                    $server->zone_id = 5;
                    break;
                case 'STKBAR':
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
                    $server->zone_id = 12;
                    break;
                case 'default':
                    continue;
                    //$server->zone_id = 9;
                    break;
            }
            $server->server_group = 1;
            if ($server->save())
                $i++;
        }
        echo "ENDED: " . $i . ' records';
    }

    public function convertUsers() {
        $user_list = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('zfl_i_users')->queryAll();
        $i = 0;
        foreach ($user_list as $user) {
            $fluser = new CFLUsers('import');
            $fluser->user_id = $user['userid'];
            $fluser->username = $user['username'];
            $fluser->password = $user['password'];
            $fluser->email = $user['email'];
            $fluser->nickname = $user['usertitle'];
            $fluser->site_role_id = 3;
            //$fluser->join_date = 'NO';
            //$fluser->last_activity = $user['lastactivity'];
            //$fluser->last_visit = $user['lastvisit'];
            $fluser->time_zone = $user['timezoneoffset'];
            $fluser->join_ip= $fluser->last_ip= $user['ipaddress'];
            $fluser->salt=$user['salt'];
            if ($fluser->save())
                $i++;
        }
        echo "ENDED: " . $i . ' records';
    }

}