<?

/**
 * @property $user_id
 * @property $user_ip
 * @property $user_hash
 * @property $last_active
 *
 */
class CFLUsersSessions extends CActiveRecord {

    /**
     *
     * @param type $className
     * @return CFLUsersSessions
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{users_sessions}}';
    }

    public function rules() {
        return array(
        );
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

}