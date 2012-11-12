<?php

class CatalogController extends AdmController {

    public function actionIndex() {
        $model = new CFLCatalogClicks('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CFLCatalogClicks'])) {
            $model->attributes = $_GET['CFLCatalogClicks'];
        }

        $this->render('list', array('model' => $model));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLCatalogClicks::model()->findByPk($id);
            $columns = CFLCatalogClicks::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
            $this->render('index', array('table' => $table));
        }
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CFLCatalogClicks::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}