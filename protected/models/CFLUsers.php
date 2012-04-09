<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $user_id
 * @property string $site_role_id
 * @property string $username
 * @property string $password
 * @property string $password_date
 * @property string $email
 * @property string $join_date
 * @property string $last_visit
 * @property string $last_activity
 * @property integer $time_zone
 * @property integer $langauge_id
 * @property integer $birthday
 * @property string $last_ip
 * @property string $join_ip
 * @property integer $confirmed_email
 * @property integer $count_friends
 * @property integer $count_unread_msg
 * @property string $salt
 * @property string $nickname
 * @property integer $userAgreement
 */
class CFLUsers extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time_zone, langauge_id, birthday, confirmed_email, count_friends, count_unread_msg, userAgreement', 'numerical', 'integerOnly' => true),
            array('site_role_id', 'length', 'max' => 11),
            array('username', 'length', 'max' => 100),
            array('password, nickname', 'length', 'max' => 32),
            array('email', 'length', 'max' => 254),
            array('last_ip, join_ip', 'length', 'max' => 16),
            array('salt', 'length', 'max' => 3),
            array('password_date, join_date, last_visit', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, site_role_id, username, password, password_date, email, join_date, last_visit, last_activity, time_zone, langauge_id, birthday, last_ip, join_ip, confirmed_email, count_friends, count_unread_msg, salt, nickname, userAgreement', 'safe', 'on' => 'search'),
        );
    }

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
            'user_id' => 'User',
            'site_role_id' => 'Site Role',
            'username' => 'Username',
            'password' => 'Password',
            'password_date' => 'Password Date',
            'email' => 'Email',
            'join_date' => 'Join Date',
            'last_visit' => 'Last Visit',
            'last_activity' => 'Last Activity',
            'time_zone' => 'Time Zone',
            'langauge_id' => 'Langauge',
            'birthday' => 'Birthday',
            'last_ip' => 'Last Ip',
            'join_ip' => 'Join Ip',
            'confirmed_email' => 'Confirmed Email',
            'count_friends' => 'Count Friends',
            'count_unread_msg' => 'Count Unread Msg',
            'salt' => 'Salt',
            'nickname' => 'Nickname',
            'userAgreement' => 'User Agreement',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('site_role_id', $this->site_role_id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_date', $this->password_date, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('join_date', $this->join_date, true);
        $criteria->compare('last_visit', $this->last_visit, true);
        $criteria->compare('last_activity', $this->last_activity, true);
        $criteria->compare('time_zone', $this->time_zone);
        $criteria->compare('langauge_id', $this->langauge_id);
        $criteria->compare('birthday', $this->birthday);
        $criteria->compare('last_ip', $this->last_ip, true);
        $criteria->compare('join_ip', $this->join_ip, true);
        $criteria->compare('confirmed_email', $this->confirmed_email);
        $criteria->compare('count_friends', $this->count_friends);
        $criteria->compare('count_unread_msg', $this->count_unread_msg);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('userAgreement', $this->userAgreement);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['admin_items_per_page']),
                        )
        );
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

    /**
     * 
     * @param type $pwd
     * @param type $salt
     * @return type 
     */
    public static function makePassword($pwd, &$salt) {
        if (!$salt)
            $salt = substr(md5(time()), 0, 2);
        return md5($pwd . $salt);
    }

    public static function makeHash($pwd, $salt) {
        return md5($pwd . Yii::app()->getBaseUrl(true) . $salt);
    }

}