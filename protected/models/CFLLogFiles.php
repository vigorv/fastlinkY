<?php

class CFLLogFiles
{

    public static function FileNotAviable($id, $group_id, $sgroup_id, $zone_id, $ip){
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_sv}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip) VALUES ("' . $id . '","' . $group_id . '","' . $sgroup_id . '","' . Yii::app()->user->id . '","' . $zone_id . '","' . $ip . '")')->execute();
    }

    public static function FileNotExists($id,$zone,$ip) {
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_not_exists}} (catalog_id,user_id,zone,ip) VALUES ("'.$id.'","'.Yii::app()->user->id.'","'.$zone.'","'.$ip.'")')->execute();
    }

}

?>