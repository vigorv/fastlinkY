<h3> </h3>
<?php
	if (!empty($info['meta_title']))
		$this->setPageTitle($info['meta_title']);
	if (!empty($info['meta_keywords']))
		Yii::app()->clientScript->registerMetaTag($info['meta_keywords'], 'keywords');
	if (!empty($info['meta_description']))
		Yii::app()->clientScript->registerMetaTag($info['meta_description'], 'description');

	echo '<h2>' . $info['meta_title'] . '</h2>';
     if($info['text_txt']=='')   {
         echo 'Page text not exist.';
     }else
	echo $info['text_txt'];