<?php

/**
 * This is the model class for table "{{pages_texts}}".
 *
 * The followings are the available columns in table '{{pages_texts}}':
 * @property string $text_id
 * @property string $text_lang
 * @property string $text_txt
 * @property string $meta_title
 * @property integer $text_active
 * @property string $modified
 * @property integer $page_id
 */
class CFLPagesTexts extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return PagesTexts the static model class
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
        return '{{pages_texts}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text_active, page_id', 'numerical', 'integerOnly'=>true),
            array('text_lang', 'length', 'max'=>3),
            array('meta_title', 'length', 'max'=>32),
            array('text_txt, modified', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('text_id, text_lang, text_txt, meta_title, text_active, modified, page_id', 'safe', 'on'=>'search'),
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
            'text_id' => 'Text',
            'text_lang' => 'Text Lang',
            'text_txt' => 'Text Txt',
            'meta_title' => 'Meta Title',
            'text_active' => 'Text Active',
            'modified' => 'Modified',
            'page_id' => 'Page',
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

        $criteria->compare('text_id',$this->text_id,true);
        $criteria->compare('text_lang',$this->text_lang,true);
        $criteria->compare('text_txt',$this->text_txt,true);
        $criteria->compare('meta_title',$this->meta_title,true);
        $criteria->compare('text_active',$this->text_active);
        $criteria->compare('modified',$this->modified,true);
        $criteria->compare('page_id',$this->page_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}