<?php

Yii::import('ext.classes.SimpleMail');

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FLFormRegister extends CFormModel {

    public $username;
    public $password;
    public $password_repeat;
    public $email;
    public $UserAgreement;
    public $verifyCode;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password,password_repeat,email', 'required'),
            // password needs to be authenticated
            array('password', 'ext.validators.EPasswordStrength', 'min' => 5),
            array('email', 'email'),
            array('username', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('username,password', 'length', 'max' => 32, 'min' => 3),
            array('UserAgreement', 'required', 'requiredValue' => '1','message'=>Yii::t('user','You should accept UserAgreement')),
            array('username,email', 'userExists'),
            array('password_repeat', 'compare','compareAttribute'=>'password','message'=> Yii::t('user','Password repeat should be equal password')),
//            array('email', 'length', 'max' => 254), // RFC 5321
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => Yii::t('user', 'Remember me next time'),
            'password' => Yii::t('user', 'Password'),
            'password_repeat' => Yii::t('user', 'Password Repeat'),
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'email'),
            'UserAgreement' => Yii::t('user','UserAgreement'),
            'verifyCode' => Yii::t('common', 'verifyCode'),
        );
    }

    public function userExists($attribute, $params) {
        //  echo $attribute;
        //$this->email = $p->purify($this->email);
        //t$his->username = $p->purify($this->username);
        switch ($attribute) {
            case 'email':
                $email_exist = CFLUsers::model()->count('email ="' . $this->email . '"');
                if ($email_exist)
                    $this->addError('email', Yii::t('user','User with this address already registred.'));
                break;
            case 'username':
                $user_exist = CFLUsers::model()->count('username="' . $this->username . '"');
                if ($user_exist)
                    $this->addError('username', Yii::t('user','User already exists'));
                break;
        }
    }

    public function register() {
        if ($this->_identity === null) {
            //Данные уже свалидированы
            $salt = false;
            $user = new CFLUsers('add');
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password_date = time();
            $user->userAgreement = $this->UserAgreement;
            $user->password = CFLUsers::MakePassword($this->password, $salt);
            $user->salt = $salt;
            $user->last_ip= $user->join_ip = Yii::app()->request->getUserHostAddress();
            if ($user->save()) {
                $this->sendConfirmMail($user);
                return true;
            }
        }
        return false;
    }

    public function sendConfirmMail($user) {
        //ОТПРАВКА ПИСЬМА СО ССЫЛКОЙ НА ПОДТВЕРЖДЕНИЕ
        $headers = "From: " . Yii::app()->params['adminEmail'] . "\r\nReply-To: " . $user['email'];
        $hashLink = Yii::app()->getBaseUrl(true) . '/users/register?hash=' . CFLUsers::makeHash($user['password'], $user['salt']).'&user_id='.$user['user_id'];
        $body = "Здравствуйте!\n\n"
                . "Для подтверждения регистрации на сайте " . Yii::app()->name . ", пожалуйста, перейдите по следующей ссылке:\n\n"
                . "{$hashLink}\n\n"
                . "Если вы не регистрировались на данном ресурсе, просто удалите это письмо.\n\n"
                . "С уважением, администрация " . Yii::app()->name;

        $ml = new SimpleMail();
        $ml->setFrom(Yii::app()->params['adminEmail']);
        $ml->setTo($user['email']);
        $ml->setSubject(Yii::t('user', 'Confirm registration'));
        $ml->setTextBody($body);
        $ml->send();

        return $body;
    }

}
