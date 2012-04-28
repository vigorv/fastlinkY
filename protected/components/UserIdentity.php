<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $email;
    private $_id = 0;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $record = CFLUsers::model()->findByAttributes(array('username' => $this->username));

        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($record->password !== md5($this->password . $record['salt']))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->errorCode = self::ERROR_NONE;
            $this->_id = $record->user_id;
            $site_role = CFLSiteRoles::model()->findByPk($record->site_role_id);
            if ($site_role)
                Yii::app()->user->setState('role', $site_role->site_role_title);
            $ukey= CFLUsers::UKey($record);
            Yii::app()->user->setState('ukey',$ukey);
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}