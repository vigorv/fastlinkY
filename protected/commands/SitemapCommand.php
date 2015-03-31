<?php
Yii::import('application.modules.admin.models.*');
Yii::import('application.modules.admin.controllers.*');
Yii::import('application.modules.admin.components.*');
Yii::import('application.modules.admin.*');
Yii::import('application.models.*');
//Yii::setPath('/var/www/html/fastlinkY/protected/modules/admin/models');
class SitemapCommand extends CConsoleCommand
{
    public function actionHello() {
            //echo 'Hello, ' . $name . '! You are ' . $age . ' years old.' . PHP_EOL;
            $rmdata = new RMData();

    }
    
    public function actionUnLinkData(){
            set_time_limit(0);
            ini_set('memory_limit','512M');
            $rmdata = new RMData();
            //$rmdata->makeCache();
            $date = date("Y-m-d H:i:s",strtotime('-1 day'));
            $i=0;
            $catalog = CFLCatalog::model()->findAll('`group` <> 0 AND `sgroup` in (2,5,6,7) AND dt<=:date order by id ',array(':date'=>$date));
            echo "count:".count($catalog)."\n";
    	    foreach ($catalog as $item){
                $i++;
        	if($i%500==0)echo "..".$i."\n";
                $news_id = Yii::app()->db->createCommand("SELECT id FROM `rum_c_cat` WHERE `xfields` LIKE '%/catalog/viewv/".$item['id']."%'")->queryScalar();
                if($news_id){
                //echo "+ found news for link ".$item['id']."<br>\n";
                //echo "SET group ".$news_id." for link ".$item['id']."<br/>";
                } else {
                    echo "-not found news for link ".$item['id']."<br>\n";
            	    //echo $item['id']."\n";
                    //Yii::app()->db->createCommand('UPDATE `fl_catalog` set `group`=0 WHERE id =:item_id')->bindValues(array(':item_id'=>$item['id']))->execute();
                }
            }
            echo "\n done<br>\n";
    }
    public function actionLinkData()
    {
	UtilsController::actionLinkData();
    }
    public function actionLinkDataOrKill()
    {
	UtilsController::actionLinkDataOrKill();
    }

}