<?php

class BannersController extends AdmController {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new CFLBanners('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CFLBanners']))
            $model->attributes = $_GET['CFLBanners'];

        $this->render('list', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLBanners::model()->findByPk($id);
            $columns = CFLBanners::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
            $this->render('index', array('table' => $table));
        }
    }
    
    public function actionCreate() {
        $model = new CFLBanners;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CFLBanners'])) {
            $model->attributes = $_POST['CFLBanners'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CFLBanners'])) {
            $model->attributes = $_POST['CFLBanners'];
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
        $model = CFLBanners::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    
    public function actionDelete($id){
        $model = $this->loadModel($id);
        if ($model){
                 $model->deleteByPk($id);
                 echo 'Deleted';
        } else {
            echo "not found";
        }

    }
    
}