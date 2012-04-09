<?php
/**
 * @property $id
 * @property $name
 * @property $place
 * @property $start
 * @property $stop
 * @property $forever
 * @property $fixed
 * @property $srt
 * @property $code
 * @property $tail
 * @property $priority
 * @property $is_webstream
 * @property $is_internet
 */
class CFLBanners extends CActiveRecord{
       /**
     *
     * @param type $className
     * @return CFLBanners
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{banners}}';
    }
    
    public function getFullColumnsList(){
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM '.$this->tableName())->queryAll();
    }
    
    public function getBanner($name){
        return $this->cache(100)->findByAttributes(array('place'=>$name))->code;
    }
}