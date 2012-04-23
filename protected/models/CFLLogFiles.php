<?php

class CFLLogFiles
{

    public static function FileNotAviable($file,$zone,$ip){
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_sv}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip) VALUES ("' . $file["id"] . '","' . $file['group'] . '","' . $file['sgroup'] . '","' . Yii::app()->user->id . '","' . $zone . '","' . $ip . '")')->execute();
    }

    public static function FileNotExists($id,$zone,$ip) {
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_not_exists}} (catalog_id,user_id,zone,ip) VALUES ("'.$id.'","'.Yii::app()->user->id.'","',$zone.'","'.$ip.'"')->execute();
    }

}

?>