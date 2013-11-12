<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $email;
    private $_id = 0;
    public $rememberMe = 1;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $this->errorCode = self::ERROR_USERNAME_INVALID;
        if (!$this->checkAuthInfo()) {
            /** @var CFLUsers $record  */
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
                $ukey = CFLUsers::UKey($record);
                Yii::app()->user->setState('ukey', $ukey);
                $hash = $this->createHash($record->password);
                $this->saveAuthInfo($record->user_id,$hash);
            }
        } else {
            $record = CFLUsers::model()->findByAttributes(array('username' => $this->username));
            if ($record){
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $record->user_id;
                $site_role = CFLSiteRoles::model()->findByPk($record->site_role_id);
                 if ($site_role)
                    Yii::app()->user->setState('role', $site_role->site_role_title);
                 $ukey = CFLUsers::UKey($record);
                    Yii::app()->user->setState('ukey', $ukey);
            }
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }


    /**
     * СРАВНИВАЕМ ДАННЫЕ СЕССИИ И КУКИ
     * пробуем восстановить сессию по данным из куки (autologin)
     *
     * @return boolean
     */
    public function checkAuthInfo()
    {
        $cookies = Yii::app()->request->getCookies();
        if (!empty($cookies['FLUserID']))
            $FLUserID = $cookies['FLUserID']->value;

        if (!empty($cookies['FLUserHash']))
            $FLUserHash = $cookies['FLUserHash']->value;

        if (!empty($FLUserID) && !empty($FLUserHash)
            && ($FLUserID == Yii::app()->user->getState('FLUserID'))
            && ($FLUserHash == Yii::app()->user->getState('FLUserHash'))
            && (Yii::app()->request->userHostAddress == Yii::app()->user->getState('FLUserIP')) //ВРЕМЕННО УБИРАЕМ ПРОВЕРКУ ПО АДРЕСУ
            && (Yii::app()->user->getState('FLHashExpired') > time())
        ) {
            $this->errorCode = self::ERROR_NONE;
            return true;
        }

        if (!empty($FLUserID) && !empty($FLUserHash)) {
            //ПРОБУЕМ ВОССТАНОВИТЬ АВТОРИЗАЦИЮ ЧЕРЕЗ КУКИ
            $cmd = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{users}} u')
                ->join('{{users_sessions}} us', 'u.user_id = us.user_id')
                ->where('u.user_id = :id', array(':id' => $FLUserID))
                ->limit(1);
            $userInfo = $cmd->queryRow();

            if (($userInfo['user_hash'] == $FLUserHash)
               // && ($this->createHash($userInfo) == $FLUserHash)
            ) {
                $this->username = $userInfo['username'];
                $this->errorCode = self::ERROR_NONE;
                //ВОССТАНАВЛИВАЕМ АВТОРИЗАЦИЮ И ПЕРЕГЕНЕРИРУЕМ ХЭШ СЕССИИ АВТОРИЗАЦИИ
                $this->rememberMe = 1; //ЕСЛИ ВОССТАНАВЛИВАЕМ ИЗ КУК? ЗНАЧИТ И ДАЛЕЕ БУДЕМ ЭТИ КУКИ ПОМНИТЬ
                $hash = $this->createHash($userInfo['password']);
                $this->saveAuthInfo($userInfo['user_id'],$hash);
                return true;
            }
            $this->dropAuthInfo();
        }
        return false;
    }


    public function createHash($pwd)
    {
        $ip = Yii::app()->request->userHostAddress;
        $hash = md5( $pwd . $ip . time() .$ip);
        return $hash;
    }

    /**
     * удалить данные авторизации и разлогинить пользователя
     *
     */
    public function dropAuthInfo()
    {
        Yii::app()->user->clearStates();

        Yii::app()->request->cookies->remove('FLUserID');
        Yii::app()->request->cookies->remove('FLUserHash');

        Yii::app()->user->logout();
    }


    /**
     * данные сессии для авторизации сохраняем в сессии пользователя, куках и корректируем данные в БД
     *
     * @param mixed $userInfo - данные записи пользователя в БД
     */
    public function saveAuthInfo($user_id,$hash)
    {
        $ip = Yii::app()->request->userHostAddress;
        $userSession = CFLUsersSessions::model()->findByAttributes(array('user_id' => $user_id));
        if (!isset($userSession)) {
            $userSession = new CFLUsersSessions();
            $userSession->user_id = $user_id;
        }

        $FLUserID = new CHttpCookie('FLUserID', $user_id);
        $FLUserHash = new CHttpCookie('FLUserHash', $hash);
        if ($this->rememberMe) {
            $expire = time() + 3600 * 24 * 30; // 30 days
            $FLUserID->expire = $expire;
            $FLUserHash->expire = $expire;
        } else {
            $FLUserID->expire = 0;
            $FLUserHash->expire = 0;
        }
        Yii::app()->request->cookies->add('FLUserId', $FLUserID);
        Yii::app()->request->cookies->add('FLUserHash', $FLUserHash);

        $userSession->user_hash = $hash;
        $userSession->user_ip = $ip;
        $userSession->last_active = date('Y-m-d H:i:s');
        $userSession->save();
    }
}