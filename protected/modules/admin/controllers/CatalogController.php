<?php

class CatalogController extends AdmController {

    public function actionIndex() {
        /* $per_page = 20;

          $criteria = new CDbCriteria();
          $count = CFLCatalog::model()->count($criteria);

          $pages = new CPagination($count);
          $pages->pageSize = $per_page;
          $pages->applyLimit($criteria);

          $list = CFLCatalog::model()->getCommandBuilder()
          ->createFindCommand(CFLCatalog::model()->tableSchema, $criteria)
          ->queryAll();

          $table = $this->renderPartial('/elements/tableview', array('list' => $list, 'pages' => $pages), true);
          $this->render('index', array('table' => $table));
         */

        $model = new CFLCatalog('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CFLCatalog'])) {

            $model->attributes = $_GET['CFLCatalog'];
        }

        $this->render('list', array('model' => $model));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLCatalog::model()->findByPk($id);
            $columns = CFLCatalog::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
            $this->render('index', array('table' => $table));
        }
    }

    public function actionAdd() {
        $item = CFLCatalog::model()->getFullColumnsList();
        if ($_POST) {
            $data = new CFLCatalog();
        }


        //var_dump($item);exit();
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CFLCatalog'])) {
            $model->attributes = $_POST['CFLCatalog'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CFLCatalog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}