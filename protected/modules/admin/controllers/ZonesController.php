<?php

class ZonesController extends AdmController {

    public function actionIndex() {
        $per_page = 20;

        $criteria = new CDbCriteria();
        $criteria->order = 'zone_id';
        $count = CFLZones::model()->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = $per_page;
        $pages->applyLimit($criteria);
        //$criteria->select='zone_id,inet_ntoa(zone_ip) as zone_ip,(zone_mask),zone_title,zone_active,zone_prio';

        $list = CFLZones::model()->getCommandBuilder()
                ->createFindCommand(CFLZones::model()->tableSchema, $criteria)
                ->queryAll();


        $sub_criteria = new CDbCriteria();
        foreach ($list as $itm) {
            $sub_criteria->condition = 'zone_id = ' . $itm['zone_id'];
            $itm['sub_item'] = CFLZonesRanges::model()->getCommandBuilder()
                    ->createFindCommand(CFLZonesRanges::model()->tableSchema, $sub_criteria)
                    ->queryAll();
        }


        if (isset($_REQUEST['ip'])) {
            $ip = filter_var($_REQUEST['ip']);
            $zones_list = CFLZones::model()->getZones($ip);
            $zones_active_list =CFLZones::model()->getActiveZones($ip);
            $zone_view = '<h4>All Zones for '.$ip.'</h4>';
            $zone_view .= $this->renderPartial('/elements/tableprint',array('list'=>$zones_list),true);
            $zone_view .= '<h4>Client zone List '.$ip.'</h4>';
            $zone_view .=$this->renderPartial('/elements/tableprint',array('list'=>$zones_active_list),true);
            
            $ar_active_zones=array();
            foreach ($zones_active_list as $zone){
                $ar_active_zones []= $zone['zone_id'];
            }
            
            $lst_active_zones=implode(',', $ar_active_zones);
            
            
//            $sv_criteria = new CDbCriteria();            
//            $sv_criteria->alias='servers';
//            $sv_criteria->join = 'left join {{zones}} z ON z.`zone_id` = `servers`.`zone_id`';
//            $sv_criteria->condition='`servers`.`zone_id` in ('.$lst_active_zones.')';
//            $sv_criteria->order='z.zone_prio DESC';
//            $servers_list = CFLServers::model()->getCommandBuilder()
//                    ->createFindCommand(CFLServers::model()->tableSchema, $sv_criteria)
//                    ->queryAll();   
            
            $servers_list =  CFLServers::model()->getServersInZones($lst_active_zones);
           // var_dump($servers_list);
            $zone_view .= '<h4>All servers in active zones for  '.$ip.'</h4>';
            $zone_view .= $this->renderPartial('/elements/tableprint',array('list'=>$servers_list),true);
        } else
            $zone_view='';
        
        
        
        
        
        $table = $this->renderPartial('/elements/tableview_ext', array('list' => $list, 'pages' => $pages), true);
        $this->render('index', array('table' => $table, 'zone_view' => $zone_view));
    }

    public function actionView($id = 0) {
        if (!$id)
            $this->actionIndex();
        else {
            $item = CFLZones::model()->findByPk($id);
            $columns = CFLZones::model()->getFullColumnsList();
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);

            $criteria = new CDbCriteria();
            $criteria->select = 'range_id,INET_NTOA(range_ip),range_mask,range_desc';
            $criteria->condition = 'zone_id =' . $id;
            $list = CFLZonesRanges::model()->getCommandBuilder()
                    ->createFindCommand(CFLZonesRanges::model()->tableSchema, $criteria)
                    ->queryAll();
            $tableR = $this->renderPartial('/elements/tableview', array('list' => $list), true);
            $table = $this->renderPartial('/elements/view_edit', array('item' => $item, 'columns' => $columns), true);

            $this->render('index', array('table' => $table, 'tableR' => $tableR));
        }
    }

    public function actionAdd() {
        $item = CFLZones::model()->getFullColumnsList();
        $item[1]['Type'] = "varchar";
        //var_dump($item);exit();
        $table = $this->renderPartial('/elements/add', array('item' => $item), true);
        $this->render('index', array('table' => $table));
    }

}