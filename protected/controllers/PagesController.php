<?php

/**
 * контроллер статических страниц
 *
 */
class PagesController extends Controller {

    public function actionView($pagename) {

        $criteria = new CDbCriteria();
        $criteria->select = 'p.*,pt.*';
        $criteria->alias = 'p';
        $criteria->join = 'LEFT JOIN {{pages_texts}} pt ON pt.page_id = p.page_id AND pt.text_active=1 AND pt.text_lang="' . Yii::app()->language . '"';
        $criteria->condition = 'p.alias = "' . $pagename . '" AND p.page_active = 1 ';
        $pages = CFLPages::model()->getCommandBuilder()
                ->createFindCommand(CFLPages::model()->tableSchema, $criteria)
                ->queryRow();
        if (!$pages) {
            $this->render('/elements/messages', array('msg' => 'Page not found'));
            Yii::app()->end();
        }
        $this->render('index', array('info' => $pages));
    }

}