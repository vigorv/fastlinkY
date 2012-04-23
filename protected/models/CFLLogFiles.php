<?php

class CFLLogFiles extends CFLLogActiveRecord
{

    /**
     *
     * @param string $className
     * @return CFLLogFiles
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{catalog_log_files}}';
    }

    public function FileNotAviable($id,$zone,$ip){
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_file_sv}} (catalog_id,user_id,zone,ip) VALUES ("' . $id . '","' . Yii::app()->user->id . '","' . $zone . '","' . $ip . '")')->execute();
    }

    public function FileNotExists($id,$zone,$ip) {
        return Yii::app()->dblog->createCommnad('INSERT DELAYED INTO {{catalog_file_not_exists}} (catalog_id,user_id,zone,ip)) VALUES ("'.$id.'","'.Yii::app()->user->id.'","',$zone.'","'.$ip.'"')->execute();
    }

}

?>