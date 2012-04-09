<?

/**
 * @property $user_id
 * @property $recover_email
 * @property $recover_hash
 * @property $recover_ip
 * 
 */
class CFLUsersRecovery extends CActiveRecord {

    /**
     *
     * @param type $className
     * @return CFLUsersRecovery
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{users_recovery}}';
    }

    public function rules() {
        return array(
        );
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

}