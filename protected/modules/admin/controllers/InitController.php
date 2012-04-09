<?php

class InitController extends AdmController {

    public function beforeAction($action) {
        parent::beforeAction($action);
        if (Yii::app()->params['init'] == true)
            return true;
        else
            $this->render('/elements/messages', array('msg' => "<h3>Init not allowed</h3>"));
        ;
    }

    public function actionInstall() {

        $auth = Yii::app()->authManager;

        //сбрасываем все существующие правила
        $auth->clearAll();

        //Операции управления пользователями.
        $auth->createOperation('createUser', 'создание пользователя');
        $auth->createOperation('viewUsers', 'просмотр списка пользователей');
        $auth->createOperation('readUser', 'просмотр данных пользователя');
        $auth->createOperation('updateUser', 'изменение данных пользователя');
        $auth->createOperation('deleteUser', 'удаление пользователя');
        $auth->createOperation('changeRole', 'изменение роли пользователя');

        $bizRule = 'return Yii::app()->user->id==$params["user"]->u_id;';
        $task = $auth->createTask('updateOwnData', 'изменение своих данных', $bizRule);
        $task->addChild('updateUser');

        //создаем роль для пользователя admin и указываем, какие операции он может выполнять
        $role = $auth->createRole('admin');
        $role->addChild('createUser');
        $role->addChild('viewUsers');
        $role->addChild('readUser');
        $role->addChild('updateOwnData');

        //все пользователи будут создаваться по-умолчанию с ролью user,
        //только root может менять роль другого пользователя
        //создаем роль для пользователя root
        $role = $auth->createRole('root');
        //наследуем операции, определённые для admin'а и добавляем новые
        $role->addChild('admin');
        $role->addChild('updateUser');
        $role->addChild('deleteUser');
        $role->addChild('changeRole');

        //создаем операции для user'а
        $bizRule = 'return Yii::app()->user->id==$params["contact"]->c_user_id;';

        $auth->createOperation('createContact', 'создание контакта');
        $auth->createOperation('viewContacts', 'просмотр списка контактов');
        $auth->createOperation('readContact', 'просмотр контакта', $bizRule);
        $auth->createOperation('updateContact', 'редактирование контакта', $bizRule);
        $auth->createTask('deleteContact', 'удаление контакта', $bizRule);

        //создаем роль user и добавляем операции для неё
        $user = $auth->createRole('user');

        $user->addChild('createContact');
        $user->addChild('viewContacts');
        $user->addChild('readContact');
        $user->addChild('updateContact');
        $user->addChild('deleteContact');
        $user->addChild('updateOwnData');

        //создаем пользователя root (запись в БД в таблице users)
        //тут используем DAO, т.к. AR автоматически назначит пользователю роль user
        //$sql = 'INSERT INTO users(u_name, u_email, u_pass, u_state, u_role)'
          //      . ' VALUES ("root", "test@test.ru", "' . md5('11111')
            //    . '", ' . Users::STATE_ACTIVE . ', "' . Users::ROLE_ROOT . '")';
        $conn = Yii::app()->db;
        $conn->createCommand($sql)->execute();

        //связываем пользователя с ролью
        $auth->assign('root', $conn->getLastInsertID());

        //сохраняем роли и операции
        $auth->save();

        $this->render('install');
    }

}