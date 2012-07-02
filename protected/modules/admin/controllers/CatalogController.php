<?php

class CatalogController extends AdmController {

    public function actionIndex() {
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


    public function actionDelete($id){
        $model = $this->loadModel($id);
        $url=false;
        if ($model){
            $data = urlencode($model->dir . '/' . $model->original_name);
            //echo Yii::app()->params['master_key'];
            if (defined('YII_DEBUG'))
            echo $model->dir.'/'.$model->original_name;
            $sdata = md5($data.Yii::app()->params['master_key']);
            $urls = array();
         switch($model->sgroup){
             case 2:
                $urls[] = 'http://'. Yii::app()->params['uploadServer_sg2'].'/files/delete';
                $urls[] = 'http://'. Yii::app()->params['uploadServerA_sg2'].'/files/delete';
                break;
             case 4:
                $urls[] = 'http://'. Yii::app()->params['uploadServer'].'/files/delete';
                break;
             default:
         }
            $res=array();
            foreach($urls as $url){
                $res[]=@file_get_contents($url.'?data='.$data.'&key='.$sdata);
            }
                if ((count($res)==1 && $res[0]=="OK") || (count($res)>1 && $res[0]=="OK" && $res[1]=="OK" )){
                    $model->deleteByPk($id);
                    echo 'Deleted';
                } else{
                    echo "Can't delete";
                    if (defined('YII_DEBUG')){
                        var_dump($urls);
                        echo '?data='.$data.'&key='.$sdata;
                    }
                }
        } else {
            echo "not found";
        }

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