<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FLFormLogin extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
// username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Запомнить меня',
            'username' => Yii::t('user', 'Username'),
            'password' => Yii::t('user', 'Password')
        );
    }

    public function authenticate($attribute, $params) {


        // Проверяем были ли ошибки в других правилах валидации.
        // если были - нет смысла выполнять проверку
        if (!$this->hasErrors()) {
            // Создаем экземпляр класса UserIdentity
            // и передаем в его конструктор введенный пользователем логин и пароль (с формы)
            $this->_identity = new UserIdentity($this->username, $this->password);
            // Выполняем метод authenticate (о котором мы с вами говорили пару абзацев назад)
            // Он у нас проверяет существует ли такой пользователь и возвращает ошибку (если она есть)
            // в $identity->errorCode
            $this->_identity->authenticate();

            // Теперь мы проверяем есть ли ошибка..   
            switch ($this->_identity->errorCode) {
                case UserIdentity::ERROR_USERNAME_INVALID: {
                        // Если логин был указан наверно - создаем ошибку
                        $this->addError('username', 'Пользователь не существует!');
                        break;
                    }
                case UserIdentity::ERROR_PASSWORD_INVALID: {
                        // Если пароль был указан наверно - создаем ошибку
                        $this->addError('password', 'Вы указали неверный пароль!');
                        break;
                    }
            }
        }
    }

    public function login() {
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($this->_identity, 0);
            $criteria = new CDbCriteria();
            $criteria->alias = 'u';
            $criteria->select = 'u.*,sr.*';
            $criteria->condition = 'u.username="' . Yii::app()->user->name . '"';
            $criteria->join = 'LEFT JOIN {{site_roles}} sr on sr.site_role_id = u.site_role_id';
            $user = CFLUsers::model()->getCommandBuilder()
                    ->createFindCommand(CFLUsers::model()->tableSchema, $criteria)
                    ->queryRow();

            Yii::app()->db->createCommand('UPDATE {{users}} SET last_ip = "' . Yii::app()->request->getUserHostAddress() . '" where user_id=' . $user['user_id'])->execute();

            if (($user['confirmed_email'] == 1) && (Yii::app()->params['email_confirm']==true)) {
                
            } else {
                Yii::app()->user->logout();
                $this->addError('username', Yii::t('user','Your mail isn\'t confirmed. Please confirm it. If you didn\'t get email just restore your password.'));
                return false;
            }
            //Yii::app()->user->setState('role', $user['site_role_title']);
            return true;
        }
        else
            return false;
    }

}
