<?php

class UsersController extends AdmController {

    public function actionIndex() {
        /* $per_page = 20;

          $criteria = new CDbCriteria();
          $count = CFLUsers::model()->count($criteria);

          $pages = new CPagination($count);
          $pages->pageSize = $per_page;
          $pages->applyLimit($criteria);

          $list = CFLUsers::model()->getCommandBuilder()
          ->createFindCommand(CFLUsers::model()->tableSchema, $criteria)
          ->queryAll();


          $table = $this->renderPartial('/elements/tableview', array('list' => $list, 'pages' => $pages), true);
          $this->render('index', array('table' => $table)); */


        $model = new CFLUsers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CFLUsers'])) {

            $model->attributes = $_GET['CFLUsers'];
        }

        $this->render('list', array('model' => $model));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLUsers::model()->findByPk($id);
            $columns = CFLUsers::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
            $this->render('index', array('table' => $table));
        }
    }

    public function actionAdd() {
        $item = CFLUsers::model()->getFullColumnsList();
        //var_dump($item);exit();
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

}