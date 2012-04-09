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

class CFLCatalogClicks extends CActiveRecord {

    /**
     *
     * @param type $className
     * @return CFLCatalog
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{catalog_clicks}}';
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

    public function InsertDelayed($file,$zone,$ip){   
        return Yii::app()->db->createCommand('INSERT DELAYED INTO {{catalog_clicks}} (catalog_id,catalog_group_id,catalog_sgroup_id,user_id,zone,ip) VALUES ("'.$file["id"].'","'.$file['group'].'","'.$file['sgroup'].'","'.Yii::app()->user->id.'","'.$zone.'","'.$ip.'")')->execute();
    }
    
}

?>