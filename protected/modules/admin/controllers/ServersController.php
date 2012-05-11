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
            $columns = CFLServers::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
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
        //var_dump($item);exit();
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

}

?>