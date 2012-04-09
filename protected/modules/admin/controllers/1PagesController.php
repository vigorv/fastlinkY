<?php

class PagesController extends AdmController {

    public function actionIndex() {
        $per_page = 20;

        $criteria = new CDbCriteria();
        $count = CFLPages::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = $per_page;
        $pages->applyLimit($criteria);

        $list = CFLPages::model()->getCommandBuilder()
                ->createFindCommand(CFLPages::model()->tableSchema, $criteria)
                ->queryAll();

        $table = $this->renderPartial('/elements/tableview', array('list' => $list, 'pages' => $pages), true);


        $this->render('index', array('table' => $table));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->redirect(index);
        else {
            $item = CFLPages::model()->findByPk($id);
            $columns = CFLPages::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);
            $criteria = new CDbCriteria();
            $texts = CFLPagesTexts::model()->getCommandBuilder()
                    ->createFindCommand(CFLPagesTexts::model()->tableSchema, $criteria)
                    ->queryAll();
            $tableT = $this->renderPartial('/elements/tableview', array('list' => $texts), true);

            $this->render('index', array('table' => $table, 'tableT' => $tableT, 'item_id' => $id));
        }
    }

    public function actionAdd() {
        $item = CFLPages::model()->getFullColumnsList();
        //$item[1]['Type'] = "varchar";

        if (isset($_POST['pages'])) {
            $data = new CFLPages();
            $data->attributes = $_POST['pages'];
            if ($data->save('add')) {
                echo "Added";
            } else
                echo "Not added";
        }

        //var_dump($item);exit();
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

    public function actionAddText($id = 0) {
        if (!$id)
            $this->redirect('index');
        else {
            $item = CFLPagesTexts::model()->getFullColumnsList();
            if (isset($_POST['pages'])) {
                $data = new CFLPagesTexts();
                $data->attributes = $_POST['pages'];
                if ($data->save('add')) {
                    echo "Added";
                } else
                    echo "Not added";
            }
            $table = $this->renderPartial('/elements/add', array('item' => $item,'action'=>'addText/'.$id), true);
            $this->render('index', array('table' => $table));
        }
    }

}