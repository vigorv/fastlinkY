<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    
    
     public function actionError404() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //$user_ip = (empty($_SERVER['HTTP_X_REAL_IP']) ? '' : $_SERVER['HTTP_X_REAL_IP']);
        $user_ip = $this->ip;
        $user_id = 0;
        if (!empty(Yii::app()->user->id))
            $user_id = Yii::app()->user->id;
        $link = '';
        
        if (!empty($_GET['url']))
            $link = strtr($_GET['url'], array('|' => '/', '!' => ':')); //ДЕКОДИРУЕМ УРЛ


            
//ФИКСИРУЕМ ОШИБКУ В БД
        $flError = CFL404::model()->findByAttributes(array('link' => $link));
        $event = (empty($_SERVER['HTTP_REFERER'])) ? '' : $_SERVER['HTTP_REFERER'];
        if (!$flError) {
            $flError = new CFL404();
            $flError->user_id = $user_id;
            $flError->user_ip = $this->ip;
            $flError->link = $link;
            $flError->event = $event;
            $flError->info = $user_agent;
            $flError->date = date('Y-m-d H:i:s');
            $flError->count = 1;
        } else
            $flError->count=$flError->count+1;
        $flError->save();
        $this->render('error404');
    }

    /**
     * Logs out the current user and redirect to homepage.
     */

    /**
     * Render Form 
     */
    public function actionUpload($id = 0) {
        $uploadServer = '';
        if (($id == 2) && ($this->zone <> '9'))
            $uploadServer = Yii::app()->params['uploadServer_sg2'];

        if ($id == 0)
            $uploadServer = Yii::app()->params['uploadServer'];

        $this->render('upload', array('uploadServer' => $uploadServer));
    }

}