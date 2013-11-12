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
        $data=$this->cache(100)->findByAttributes(array('place'=>$name));
        if($data)return $data->code;
        return false;
    }
    public function getBannerWithACL($name){
        $userRole = Yii::app()->user->getState('role');
        if($userRole!="admin")return $this->getBanner($name);
        else return false;
    
    }
    

        /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('place',$this->place,true);
        $criteria->compare('start',$this->start,true);
        $criteria->compare('stop',$this->stop,true);
        $criteria->compare('forever',$this->forever,true);
        $criteria->compare('fixed',$this->fixed,true);
        $criteria->compare('srt',$this->srt,true);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('tail',$this->tail,true);
        $criteria->compare('priority',$this->tail,true);
        $criteria->compare('is_webstream',$this->is_webstream,true);
        $criteria->compare('is_internet',$this->is_internet,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
   
}