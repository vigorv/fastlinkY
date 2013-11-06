<?php


class CFLLogActiveRecord extends CActiveRecord
{

    private static $dblog = null;

    protected static function getLogDbConnection()
    {
        if (self::$dblog !== null)
            return self::$dblog;
        else {
            self::$dblog = Yii::app()->dblog;
            if (self::$dblog instanceof CDbConnection) {
                self::$dblog->setActive(true);
                return self::$dblog;
            }
            else
                throw new CDbException(Yii::t('yii', 'Active Record requires a "db" CDbConnection application component.'));
        }
    }

    public function getDbConnection()
    {
        return self::getLogDbConnection();
    }
}

?>