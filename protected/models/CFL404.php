<?php

/**
 * This is the model class for table "{{404}}".
 *
 * The followings are the available columns in table '{{404}}':
 * @property string $id
 * @property string $user_ip
 * @property integer $user_id
 * @property string $link
 * @property string $event
 * @property string $info
 * @property string $date
 * @property integer $count
 */
class CFL404 extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return CFL404 the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{404}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, count', 'numerical', 'integerOnly'=>true),
            array('user_ip', 'length', 'max'=>16),
            array('link, event, info', 'length', 'max'=>255),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_ip, user_id, link, event, info, date, count', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_ip' => 'User Ip',
            'user_id' => 'User',
            'link' => 'Link',
            'event' => 'Event',
            'info' => 'Info',
            'date' => 'Date',
            'count' => 'Count',
        );
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
        $criteria->compare('user_ip',$this->user_ip,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('link',$this->link,true);
        $criteria->compare('event',$this->event,true);
        $criteria->compare('info',$this->info,true);
        $criteria->compare('date',$this->date,true);
        $criteria->compare('count',$this->count);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}