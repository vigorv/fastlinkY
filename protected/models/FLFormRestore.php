<?php

Yii::import('ext.classes.SimpleMail');
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FLFormRestore extends CFormModel {

    public $email;
    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email', 'required'),
            array('email', 'userExists'),
            // rememberMe needs to be a boolean
            array('email', 'email'),
            // password needs to be authenticated
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email'=> Yii::t('user','Email'),
            'verifyCode' => Yii::t('common','verifyCode'),
        );
    }

    public function userExists($attribute, $params) {
        $email_exist = CFLUsers::model()->count('email ="' . $this->email . '"');
        if (!$email_exist)
            $this->addError('email', Yii::t('user','User with this address not registred.'));
    }

    public function SendMailForUser() {
        $hash = md5(sha1($this->email) . time());
        $user_id = CFLUsers::model()->find('email ="' . $this->email . '"', array('select' => 'user_id'))->user_id;


        $restore = CFLUsersRecovery::model()->findByPk($user_id);

        if (!$restore)
            $restore = new CFLUsersRecovery();
        $restore->user_id = $user_id;
        if (!$restore->user_id)
            return $this->addError('email', 'Bad user');
        $restore->recover_hash = $hash;
        $restore->recover_ip = Yii::app()->request->getUserHostAddress();
        if ($restore->save()) {
            $hashLink = Yii::app()->createAbsoluteUrl('/users/restore?hash=') . $hash;
            $body = "Здравствуйте!\n\n"
                    . "Если вы забыли ваш пароль, перейдите по следующей ссылке:\n\n"
                    . "{$hashLink}\n\n"
                    . "Если вы не запрашивали восстановление пароля, просто удалите это письмо.\n\n"
                    . "С уважением, администрация ресурса " . Yii::app()->name;
        
            $ml = new SimpleMail();
            $ml->setFrom(Yii::app()->params['adminEmail']);
            $ml->setTo($this->email);
            $ml->setSubject(Yii::t('user', 'Forget password?'));
            $ml->setTextBody($body);
            $ml->send();
                return true;
            
        }
    }

}
