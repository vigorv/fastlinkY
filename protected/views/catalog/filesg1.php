<div class="overlay" id="mies">
    <a href="/" id="player">
    </a> 
</div>
<div id="myplaylist" style="display:none;">
    <a href="test">None</a>
</div>
<center>
    <h2><?= Yii::t('common', 'Download'); ?></h2>
</center>

<?php

$cloud_service_uri = Yii::app()->params['cloud_service_uri'];

mb_internal_encoding("UTF-8");
if (!function_exists('substr_replace_mb')) {

    function substr_replace_mb($string, $replacement, $start, $length) {

        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length);
    }

    function print_item($val, $key, $keys) {
        $str_len = mb_strlen($val);
        $title = '';
        if ($str_len > 33) {
            $title = $val;
            $val = substr_replace_mb($val, '...', 15, $str_len - 30);
        }
        if ($key == $keys[0]) {
            $val = '<a href="' . Yii::app()->createUrl('/admin/' . Yii::app()->controller->id . '/view/' . $val) . '">' . $val . '</a>';
        }
        echo '<td title="' . $title . '">' . $val . '</td>';
    }

}
if (!empty($files[0])):
    ?>
    <h3> <?= $files[0]['title']; ?></h3>
    <p><?= $files[0]['comment']; ?></p>
    <?
    $url = '/catalog/load/' . $file['id'];
    $aurl = Yii::app()->createAbsoluteUrl($url);//,array('target'=>'_blank'	));
    $name = $file['name'];
    $tth = $file['tth'];
    $sz = $file['sz'];
    
    switch ($files[0]['sgroup']){
        case 1: $cloud_partner_id = Yii::app()->params['cloud_service_partner_id_sg1'];break;
        case 2: $cloud_partner_id = Yii::app()->params['cloud_service_partner_id_sg2'];break;
        default: $cloud_partner_id = 0;
    }
    $ext = pathinfo(strtolower($name), PATHINFO_EXTENSION);
// Умещаем имя в 43 символа
    $str_len = strlen($name);
    if ($str_len > 43)
        $name = substr_replace_mb($name, '...', 20, $str_len - 40);
	if($tth<>'')$tth="&xt=urn:tree:tiger:".$tth;
	if($sz<>'' and $sz<>0)$sz="&xl=".$sz;
	
        ?>
        <p>
           <a href="<?= $url; ?>"><?= $name; ?></a>
        <a href="magnet:?<?=$tth?>&dn=<?=$name?><?=$sz?>">p2p</a><a href='http://videoxq.com/pages/dc-hub' target=_blank><img src=/images/p2p.jpg alt='p2p' width=20></a></p>
        <?

    if (count($files) > 1) :
        ?>
        <h3><?= Yii::t('common', 'Typically, this file also loaded with'); ?></h3>

        <?
        foreach ($files as $f) :
            if ($f['id'] == $file['id']) {
                continue;
            }
            $url = '/catalog/viewv/' . $f['id'];
            $aurl = Yii::app()->createAbsoluteUrl($url);
            $name = $f['name'];
	    $tth = $f['tth'];
	    $sz = $f['sz'];
    	    $str_len = strlen($name);
            if ($str_len > 40)
                $name = substr_replace($name, '...', 20, $str_len - 40);
	    if($tth<>'')$tth="&xt=urn:tree:tiger:".$tth;
	    if($sz<>'' and $sz<>0)$sz="&xl=".$sz;
                    ?>
        <p>
        <a href="<?= $url; ?>"><?= $name; ?></a>
        <a href="magnet:?<?=$tth?>&dn=<?=$name?><?=$sz?>">p2p</a><a href='http://videoxq.com/pages/dc-hub' target=_blank ><img src=/images/p2p.jpg alt='p2p' width=20></a></p>
        <? endforeach; ?>
    <? endif; ?>
<? else: ?>
    <h3><?= Yii::t('common', "File not found"); ?></h3>
<? endif; ?>