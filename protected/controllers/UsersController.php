<?php

class UsersController extends Controller {

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        header('Content-Type: text/html; charset=utf-8');
        header("Expires: Wed, 01 July 2009 00:00:00");
        header("Cache-Control: no-store, no-cache, must-revalidate, private");
        header("Pragma: no-cache");
        return true;
    }

    public function actionRegister($hash = '', $user_id = 0) {
        $model = new FLFormRegister();
        if ($hash == '') {
            if (!Yii::app()->user->isGuest) {
                $this->redirect('/');
            }
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['FLFormRegister'])) {
                $model->attributes = $_POST['FLFormRegister'];
                if ($model->validate() && $model->register()) {
                    $msg = Yii::t('user', 'Please, confirm your email. Instructions sended to ') . $model->email;
                    $this->render('/elements/messages', array('msg' => $msg));
                    Yii::app()->end();
                }
            }
        } else {
            $hash = filter_var($hash, FILTER_SANITIZE_STRING);
            $user_id = (int) $user_id;
            $msg = '';
            if ($user_id) {
                $user = CFLUsers::model()->findByPk($user_id);
                if ($user)
                    if ($hash == CFLUsers::makeHash($user['password'], $user['salt'])) {
                        $user->confirmed_email = 1;
                        if ($user->save()) {
                            $msg = Yii::t('user', 'Yours email is confirmed') . '! <a href="/users/login">' . Yii::t('user', 'Login') . '</a>';
                            $this->render('/elements/messages', array('msg' => $msg));
                            Yii::app()->end();
                        } else
                            $msg = 'Error: saving data';
                    } else
                        $msg = 'Error: unknown hash';
            } else
                $msg = 'Error: unknown user';
            $msg .= '<p>Yours mail is not confirmed</p>';

            $this->render('/elements/messages', array('msg' => $msg));
            Yii::app()->end();
        }

        $this->render('register', array('model' => $model));
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/');
        }
        $model = new FLFormLogin();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['FLFormLogin'])) {
            $model->attributes = $_POST['FLFormLogin'];

            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        if (!Yii::app()->user->isGuest) {
            $this->redirect('/');
        }
        $this->render('login', array('model' => $model));
    }

    public function actionRestore($hash = '') {
        $model = new FLFormRestore();
        if ($hash == '') {
            if (!Yii::app()->user->isGuest) {
                $this->redirect('/');
            }
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'restore-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['FLFormRestore'])) {
                $model->attributes = $_POST['FLFormRestore'];
                if ($model->validate() && $model->SendMailForUser()) {
                    $msg = Yii::t('user', 'Mail with instructions sended to ') . $model->email;
                    $this->render('/elements/messages', array('msg' => $msg));
                    Yii::app()->end();
                }
            }
        } else {
            $hash = filter_var($hash, FILTER_SANITIZE_STRING);
            $ur = CFLUsersRecovery::model()->find('recover_hash ="' . $hash . '" AND recover_date >= UNIX_TIMESTAMP(DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY))');
            if ($ur) {
                $user_id = $ur->user_id;
                if ($user_id) {
                    $salt = false;
                    $user = CFLUsers::model()->findByPk($user_id);
                    $pwd = CFLUtils::genRandomString(7);
                    $user->password = CFLUsers::makePassword($pwd, $salt);
                    $user->confirmed_email = 1;
                    $user->salt = $salt;
                    if ($user->save()) {
                        $msg = Yii::t('user', 'Yours new password is ') . $pwd;
                        $ur->deleteByPk($ur->user_id);
                        $this->render('/elements/messages', array('msg' => $msg));
                        Yii::app()->end();
                    }
                }
            }
        }


        $this->render('restore', array('model' => $model));
    }

    public function actionExit() {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/');
        }
        if (isset($_POST['exit'])) {
            Yii::app()->user->setState('role','');
            Yii::app()->identity->dropAuthInfo();
            Yii::app()->user->logout();
            Yii::app()->session->regenerateID(true);
        }
    }

}

?>
