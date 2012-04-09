
<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property string $page_id
 * @property string $page_name
 * @property integer $page_active
 * @property string $parent_id
 * @property string $alias
 * @property string $created
 */
class CFLPages extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Pages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pages}}';
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

    /**
     * @return array validation rules for model attributes.
     */
 public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_active', 'numerical', 'integerOnly'=>true),
            array('page_name, alias', 'length', 'max'=>255),
            array('parent_id', 'length', 'max'=>10),
            array('created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('page_id, page_name, page_active, parent_id, alias, created', 'safe', 'on'=>'search'),
        );
    }
/*
    public function rules() {
        return array(
            array('page_id', 'compare', 'compareValue' => '', 'allowEmpty' => true, 'on' => 'add'),
            array('page_name,alias', 'required', 'on' => 'add'),
            array('page_name,alias', 'length', 'min' => 3, 'max' => 10, 'allowEmpty' => false),
            array('parent_id', 'numerical', 'integerOnly' => true),
            array('page_active', 'boolean'),
                //array('server_desc','fi;]ter')
        );
    }
*/
    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'page_id' => 'Page',
            'page_name' => 'Page Name',
            'page_active' => 'Page Active',
            'parent_id' => 'Parent',
            'alias' => 'Alias',
            'created' => 'Created',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
// Warning: Please modify the following code to remove attributes that
// should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('page_id', $this->page_id, true);
        $criteria->compare('page_name', $this->page_name, true);
        $criteria->compare('page_active', $this->page_active);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}