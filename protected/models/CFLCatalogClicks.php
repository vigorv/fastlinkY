<?php

/**
 * @property $id
 * @property $catalog_id
 * @property $catalog_group_id
 * @property $created
 * @property $user_id
 * @property $zone
 * @property $ip
 * @property $catalog_sgroup_id
 * @property $server_id
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

    public function getDbConnection(){
        return Yii::app()->dblog;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('catalog_id, catalog_group_id,zone,ip,catalog_sgroup_id', 'required'),
            array('catalog_id, catalog_group_id,zone,catalog_sgroup_id,user_id,server_id', 'numerical', 'integerOnly' => true),
            array('catalog_id, catalog_group_id,zone,ip,catalog_sgroup_id,user_id', 'length', 'max' => 10),
            array('	ip', 'length', 'max' => 25),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('catalog_id, catalog_group_id,zone,created,catalog_sgroup_id,ip,user_id,server_id', 'safe', 'on' => 'search'),
        );
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('catalog_id', $this->catalog_id, true);
        $criteria->compare('catalog_group_id', $this->catalog_group_id, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('zone', $this->zone, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('catalog_sgroup_id', $this->catalog_sgroup_id, true);
        $criteria->compare('server_id', $this->server_id, true);

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['admin_items_per_page']),
            )
        );
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