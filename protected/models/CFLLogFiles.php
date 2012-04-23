<?php

class CFLLogFiles
{

    private static $_models=array();
    private static $dblog;

    public static function model($className=__CLASS__)
    {
        if(isset(self::$_models[$className]))
            return self::$_models[$className];
        else
        {
            $model=self::$_models[$className]=new $className(null);

            if (self::$dblog !== null)
                return self::$dblog;
            else {
                self::$dblog = Yii::app()->dblog;
                if (self::$dblog instanceof CDbConnection) {
                    self::$dblog->setActive(true);
                    return self::$dblog;
                }
                else
                    throw new CDbException(Yii::t('yii', 'Active Record requires a "db" CDbConnection application component.'));
            }

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