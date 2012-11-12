<?php

/**
 * @property $id
 * @property $catalog_id
 * @property $catalog_group_id
 * @property $created
 * @property $user_id
 * @property $zone
 * @property $ip
 */
class CFLCatalogClicks extends CFLLogActiveRecord {

    /**
     *
     * @param string $className
     * @return CFLCatalogClicks
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{catalog_clicks}}';
    }

    public function getFullColumnsList() {
        return Yii::app()->dblog->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }


/**
 * @param mixed $file
 * @param mixed $zone
 * @param mixed $ip
 * @return mixed
 */
    public function InsertDelayed($file, $zone, $ip, $sid=0) {
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_clicks}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip,server_id) VALUES ("' . $file["id"] . '","' . $file['group'] . '","' . $file['sgroup'] . '","' . Yii::app()->user->id . '","' . $zone . '","' . $ip . '","'.$sid.'")')->execute();
    }

    /**
     * @param mixed $file
     * @param mixed $ip
     * @return mixed
     */
    public function CheckTime($file,$ip){
        return Yii::app()->dblog->createCommand('SELECT COUNT(*) FROM {{catalog_clicks}} WHERE (`created` > DATE_SUB(NOW(), INTERVAL 1 DAY)) AND (`catalog_id` ='.$file["id"].') AND (`ip` = "'.$ip.'") LIMIT 1')->queryScalar();
    }

    /**
     * @param mixed $file
     * @param mixed $zone
     * @param mixed $ip
     * @return mixed
     */
    public function InsertDelayed2($file, $zone, $ip, $sid=0) {
        return Yii::app()->dblog->createCommand('INSERT DELAYED INTO {{catalog_clicks_all}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip) VALUES ("' . $file["id"] . '","' . $file['group'] . '","' . $file['sgroup'] . '","' . Yii::app()->user->id . '","' . $zone . '","' . $ip . '")')->execute();
    }

    /**
     * @param mixed $file
     * @param mixed $ip
     * @return mixed
     */
    public function CheckTime2($id,$ip){
        return Yii::app()->dblog->createCommand('SELECT COUNT(*) FROM {{catalog_clicks_all}} WHERE (`created` > DATE_SUB(NOW(), INTERVAL 1 DAY)) AND (`catalog_id` ='.$id.') AND (`ip` = "'.$ip.'") LIMIT 1')->queryScalar();
    }



}

?>