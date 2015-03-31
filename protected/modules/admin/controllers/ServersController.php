<?php

class ServersController extends AdmController {

    public function actionIndex() {
        /* $per_page = 20;

          $criteria = new CDbCriteria();
          $count = CFLServers::model()->count($criteria);

          $criteria->select='server_id, server_addr,INET_NTOA(server_ip) as server_ip,server_desc,server_ipv6,server_is_active,server_priority,server_letter,server_group';
          $pages = new CPagination($count);
          $pages->pageSize = $per_page;
          $pages->applyLimit($criteria);

          $list = CFLServers::model()->getCommandBuilder()
          ->createFindCommand(CFLServers::model()->tableSchema, $criteria)
          ->queryAll();

          $table = $this->renderPartial('/elements/tableview', array('list' => $list, 'pages' => $pages), true);
          $this->render('index', array('table' => $table));


         */
        $model = new CFLServers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CFLServers'])) {

            $model->attributes = $_GET['CFLServers'];
        }

        $this->render('list', array('model' => $model));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLServers::model()->findByPk($id);
            //$item['id']=$item['server_id'];
            $columns = CFLServers::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view', array('item' => $item, 'columns' => $columns), true);
            $this->render('index', array('table' => $table));
        }
    }

    public function actionAdd() {
        $item = CFLServers::model()->getFullColumnsList();
        $item[2]['Type'] = "varchar";
        if (isset($_POST['Servers'])) {
            $data = new CFLCatalog();
            $data->attributes = $_POST['Servers'];
            if ($data->save()) {
                echo "Added";
            }
        }
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
        if (isset($_POST['CFLServers'])) {
        $model->attributes = $_POST['CFLServers'];
        if ($model->save())
                //$this->redirect(array('view', 'id' => $model->server_id));
                $this->redirect(array('index'));
        }
        $this->render('update', array(
                            'model' => $model,
            ));
    }
    public function loadModel($id) {
            $model = CFLServers::model()->findByPk($id);
            if ($model === null)
                    throw new CHttpException(404, 'The requested page does not exist.');
                    return $model;
            }
    public function actionActivate($id,$state)
    {
            $model = $this->loadModel($id);
            if ($model){
             $model->setActive($id,$state);
             echo 'Updated';
          } else {
          echo "not found";
    	  }

    
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
?>