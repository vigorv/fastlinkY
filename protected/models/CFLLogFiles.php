<?php

class CFLLogFiles
{

    private static $_models=array();

    public static function model($className=__CLASS__)
    {
        if(isset(self::$_models[$className]))
            return self::$_models[$className];
        else
        {
            $model=self::$_models[$className]=new $className(null);
            return $model;
        }
    }

    public function FileNotAviable($file,$zone,$ip){
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_sv}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip) VALUES ("' . $file["id"] . '","' . $file['group'] . '","' . $file['sgroup'] . '","' . Yii::app()->user->id . '","' . $zone . '","' . $ip . '")')->execute();
    }

    public function FileNotExists($id,$zone,$ip) {
        return Yii::app()->dblog->createCommnad('INSERT DELAYED INTO {{catalog_file_not_exists}} (catalog_id,user_id,zone,ip)) VALUES ("'.$id.'","'.Yii::app()->user->id.'","',$zone.'","'.$ip.'"')->execute();
    }

}

?>