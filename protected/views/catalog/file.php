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
    function printAdminLink($url,$userRole)
    {
        //file_put_contents("/1.txt", "userRole2: " . $userRole,FILE_APPEND);
        if ($userRole == "admin") {echo "<a href=\"{$url}?key=admin\">adminLink</a>";}
    }
?>


<?
if (!empty($files[0])):
    ?>
    <h3> <?= $files[0]['title']; ?></h3>
    <p><?= $files[0]['comment']; ?></p>
    <?
    $url = '/catalog/load/' . $file['id'];
    $aurl = Yii::app()->createAbsoluteUrl($url);//,array('target'=>'_blank'	));
    $name = $file['name'];
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
    if(isset($cloud)&&is_array($cloud))
    {?>
            <!-- single playlist entry as an "template" -->
            <a href="<?= $url; ?>">
                <?= $file['name']; ?>
            </a>
            <?printAdminLink($url,$userrole);?>
            &nbsp;<button id="mainPlay" class="play" rel="#mies"><i class="icon-play"></i>
        </button>

    <?
    }
    else
    {
     switch ($ext) {

         case 'mp4':
            ?>
            <!-- single playlist entry as an "template" -->
            <a href="<?= $url; ?>">
                <?= $file['name']; ?>
            </a>
            <?printAdminLink($url,$userrole);?>
            &nbsp;<button id="mainPlay" class="play" rel="#mies"><i class="icon-play"></i>
                <div id="playlist" style="display:none;">
                    <a href="<?= $aurl; ?>">
                        <?= $file['name']; ?>
                    </a>
                    <?php if ($cloud_partner_id && isset($_GET['cloud'])):?>
                    <a href="http://<?=$cloud_service_uri;?>/api/cloudButton?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"><img width="32px" height="22px" src="http://<?=$cloud_service_uri;?>/api/statusimage?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"></a>
                    <?endif;?>
                </div>
            </button> 

            <?
            break;
        case 'avi2':
        case 'mkv2':
            ?>
            <a href="<?= $url; ?>">
                <?= $file['name']; ?>
                <?printAdminLink($url,$userrole);?>
                <?php if ($cloud_partner_id && isset($_GET['cloud'])):?>
                <a href="http://<?=$cloud_service_uri;?>/api/cloudButton?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"> <img width="32px" height="22px" src="http://<?=$cloud_service_uri;?>/api/statusimage?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"></a>
                <?endif;?>
            </a>
                <div class="overlay" id="mies2">
                <object classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="560" height="450" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">

                    <param name="custommode" value="none" />

                    <param name="autoPlay" value="true" />
                    <param name="src" value="<?= $aurl; ?>" />

                    <embed type="video/divx" src="<?= $aurl; ?>" custommode="none" width="560" height="450" autoPlay="true"  pluginspage="http://go.divx.com/plugin/download/">
                    </embed>
                </object>
            </div>
            <button  id="mainPlay" class="play2" rel="#mies2"><i class="icon-play"></i></button>

            <?
            break;
        default:
            echo '<a href="' . $url . '">' . $name . '</a><br/>';
            printAdminLink($url,$userrole);


    /*<a href="http://<?=$cloud_service_uri;?>/api/cloudButton?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"> <img width="32px" height="22px"  src="http://<?=$cloud_service_uri;?>/api/statusimage?partner_id=<?=$cloud_partner_id;?>&partner_item_id=<?=$file['id'];?>"></a>*/

            break;
    }
    }
    ?>





    <?
    if (count($files) > 1) :
        ?>
        <h3><?= Yii::t('common', 'Typically, this file also loaded with'); ?></h3>

        <a target="_blank" href="/catalog/meta/gid/<?= $file['group']; ?>/sid/<?= $file['sgroup']; ?>"> <?= Yii::t('common', 'All Files'); ?></a>
        
        <? if ($ext == 'mp4'): ?>
            &nbsp;<button class="play" rel="#mies"><i class="icon-play"></i>
                <div id="playlist" style="display:none;">
                    <? foreach ($files as $f): ?>
                        <a href="<?= '/catalog/load/' . $f['id']; ?>">
                            <?= $f['name']; ?>
                        </a>      

                    <? endforeach; ?>
                </div>
            </button> 
        <? endif; ?>
        <br/>

        <?
        foreach ($files as $f) :
            if ($f['id'] == $file['id']) {
                continue;
            }
//echo'<tr valign="middle"><td>';
// $urlFull = AppController::set_input_server($f['dir'] . '/' . $f['name'], false, $f['sgroup']);
            $url = '/catalog/load/' . $f['id'];
            $aurl = Yii::app()->createAbsoluteUrl($url);
            $pageurl = '/catalog/file/' . $f['id'];
            $purl = Yii::app()->createAbsoluteUrl($pageurl);
            
            $name = $f['name'];
//$ext= pathinfo($name,$name);
            $str_len = strlen($name);
            if ($str_len > 40)
                $name = substr_replace($name, '...', 20, $str_len - 40);
            if($f["cloud_ready"]==1 &&$f["cloud_state"]==0)
            {?>
                <a href="<?= $url; ?>"><?= $name; ?></a>
                &nbsp;<button onclick="javascript: document.location.href = '<?=$purl."/1"?>';"><i class="icon-play"></i>
            </button> <br/>
    
            <?

            }else{
            switch ($ext):
                case 'mp4':
                case 'avi2':
                case 'mkv2':
                    ?>
                    <a href="<?= $url; ?>"><?= $name; ?></a>
                    &nbsp;<button onclick="javascript: document.location.href = '<?=$purl."/1"?>';"><i class="icon-play"></i>
                    </button> <br/>

                    <?
                    break;
                default:
                    ?>
                    <a href="<?= $url; ?>"><?= $name; ?></a><br/>
            <? endswitch;} ?>
        <? endforeach; ?>
    <? endif; ?>
<? else: ?>
    <h3><?= Yii::t('common', "File not found"); ?></h3>
<? endif; 

    if(isset($cloud)&&is_array($cloud))
    {
?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	<script src="/js/uppod/uppod-0.4.9.js" type="text/javascript"></script>
	<script type="text/javascript" src="/js/uppod/video33-1468.js"></script>
<script type="text/javascript">
   var ua = navigator.userAgent.toLowerCase();
   var flashInstalled = false;
<?
//$cdn1 = Yii::app()->params['UppodServer'];
$cdn1 = CFLServers::model()->getClientServerString($this->zone,10,"");

$cloud_files=array();$nameIpone="";$nameIpad="";$names="";
foreach($cloud as $v)
{
$cloud_files[$v['id']]=$v['fpath'];
}
$cloud=$cloud_files;
if(isset($cloud[1]))$nameIpone=$cloud[1];
if(isset($cloud[2]))$nameIpad=$cloud[2];else $nameIpad=$nameIpone;
if(isset($cloud[1]))$names= "\"".$cdn1.$cloud[1];
if(isset($cloud[2]))$names.= ",".$cdn1.$cloud[2];else $names.=",";
if(isset($cloud[3]))$names.= ",".$cdn1.$cloud[3];else $names.=",";
if(isset($cloud[4]))$names.= ",".$cdn1.$cloud[4];else $names.=",";
$names.="\"";
?>	
	var names= <?=$names?>;
	ScreenWidth = screen.width;     
   if (typeof(navigator.plugins)!="undefined"&&typeof(navigator.plugins["Shockwave Flash"])=="object"){
      flashInstalled = true;
   } else if (typeof window.ActiveXObject != "undefined") {
      try {
         if (new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) {
            flashInstalled = true;
         }
      } catch(e) {};
   };
   if(ua.indexOf("iphone") != -1 || ua.indexOf("ipad") != -1 || ua.indexOf("android") != -1 || ua.indexOf("Windows Phone") != -1 || ua.indexOf("BlackBerry") != -1){
      //код HTML5
	  if (ScreenWidth > 720) var name="<?=$cdn1.$nameIpone?>";
	  if (ScreenWidth > 1000) var name="<?=$cdn1.$nameIpad?>";
	  this.player = new Uppod({m:"video",uid:"player",file:names,st:"uppodvideo",pl:"/catalog/playlist/gid/<?= $file['group']; ?>/sid/<?= $file['sgroup']; ?>"});
	  
   }else{
      if(!flashInstalled){
         //просим установить Flash
         document.getElementById("player").innerHTML="<a href=http://www.adobe.com/go/getflashplayer>Требуется обновить Flash-плеер</a>";
      }else{
         //код Flash (SWFObject)
	var flashvars = {
			file:names,
			st:"/js/uppod/video33-1468.txt",
            pl:"/catalog/playlist/gid/<?= $file['group']; ?>/sid/<?= $file['sgroup']; ?>"
			}; 
   var params = {bgcolor:"#ffffff", wmode:"window", allowFullScreen:"true", allowScriptAccess:"always"}; 
   swfobject.embedSWF("/js/uppod/uppod.swf", "player","640","100%", "10.0.0.0", false, flashvars, params);


		 }
   }</script>

<?	
	}
?>
<script language="JavaScript">
    var player = flowplayer("player", "/js/player/flowplayer-3.2.8.swf",{
        plugins: {
            mega: {
                url: "/js/player/flowplayer.pseudostreaming-3.2.8.swf"
            }, 
            controls: {
                playlist: true
            }
        },
        clip:  {
            baseUrl: '/',
            autoPlay: false,
            autoBuffering: false,
            provider: 'mega'          
        }

    }).playlist("#myplaylist", {loop:false});
</script>
    <script language="JavaScript">
    $("button.play").overlay({
        // use the Apple effect for overlay
        effect: 'apple',
 
 
        onBeforeLoad: function(){
            list = this.getTrigger().find('#playlist').html();
            $("#myplaylist").html(list); 
        },
        // when overlay is opened, load our player
        onLoad: function() {
            player.playlist("#myplaylist", {loop:false});
            player.load();            
        },
 
        // when overlay is closed, unload our player
        onClose: function() {
            player.unload();
        }
    });
    
    
    $("button.play2").overlay({
        // use the Apple effect for overlay
        effect: 'apple',
        
        onBeforeLoad: function(){
            link = this.getTrigger().find('#playlist a').attr('href');
            ov =$('#mies2');
            ov.find('param[src]').attr('src',link);
            ov.find('embed').attr('src',link);
        }
    });
<? if ($autoplay == 1): ?>
    
            $("button#mainPlay").click();
    
<? endif; ?>

</script>