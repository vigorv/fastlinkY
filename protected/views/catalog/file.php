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
/* * *
  $autoClick = '';
  function isOperaTurbo()
  {
  $agent = (empty($_SERVER['HTTP_USER_AGENT']) ? '' : strtolower($_SERVER['HTTP_USER_AGENT']));
  $hostName = strtolower(gethostbyaddr(empty($_SERVER["HTTP_X_REAL_IP"]) ? $_SERVER["REMOTE_ADDR"] : $_SERVER["HTTP_X_REAL_IP"]));
  return (
  (strpos($hostName, 'opera-mini.net') !== false)
  ||
  (strpos($agent, 'opera mini') !== false)
  );
  }

  //if (isOperaTurbo())
  if ($isOpera)
  {
  echo '<h3>' . __('Turn off the option Opera Turbo', true) . '</h3>';
  unset($files);
  }
 */
if (!empty($files[0])):
    ?>
    <h3> <?= $files[0]['title']; ?></h3>
    <p><?= $files[0]['comment']; ?></p>

    <?
    $url = '/catalog/load/' . $file['id'];
    $aurl = Yii::app()->createAbsoluteUrl($url);
    $name = $file['name'];

    $ext = pathinfo(strtolower($name), PATHINFO_EXTENSION);
// Умещаем имя в 43 символа
    $str_len = strlen($name);
    if ($str_len > 43)
        $name = substr_replace_mb($name, '...', 20, $str_len - 40);

    switch ($ext) {
        case 'mp4':
            ?>
            <!-- single playlist entry as an "template" -->
            <a href="<?= $url; ?>">
                <?= $file['name']; ?>
            </a>            
            &nbsp;<button id="mainPlay" class="play" rel="#mies"><i class="icon-play"></i>
                <div id="playlist" style="display:none;">
                    <a href="<?= $aurl; ?>">
                        <?= $file['name']; ?>
                    </a>      
                </div>
            </button> 

            <?
            break;
        case 'avi':
        case 'mkv':
            ?>
            <a href="<?= $url; ?>">
                <?= $file['name']; ?>
            </a> 
            <div class="overlay" id="mies2">
                <object classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="560" height="450" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">

                    <param name="custommode" value="none" />

                    <param name="autoPlay" value="true" />
                    <param name="src" value="<?= $aurl; ?>" />

                    <embed type="video/divx" src="<?= $aurl; ?>" custommode="none" width="560" height="450" autoPlay="false"  pluginspage="http://go.divx.com/plugin/download/">
                    </embed>
                </object>
            </div>
            <button  id="mainPlay" class="play2" rel="#mies2"><i class="icon-play"></i></button>

            <?
            break;
        default:
            echo '<a href="' . $url . '">' . $name . '</a>';
            break;
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
            $name = $f['name'];
//$ext= pathinfo($name,$name);
            $str_len = strlen($name);
            if ($str_len > 40)
                $name = substr_replace($name, '...', 20, $str_len - 40);
            switch ($ext):
                case 'mp4':
                    ?>

                    <a href="<?= $url; ?>"><?= $name; ?></a>
                    &nbsp;<button class="play" rel="#mies"><i class="icon-play"></i>
                        <div id="playlist" style="display:none;">
                            <a href="<?= $aurl; ?>">
                                <?= $name; ?>
                            </a>      
                        </div>
                    </button> <br/>
                    <?
                    break;
                case 'avi':
                case 'mkv':
                    ?>
                    <a href="<?= $url; ?>"><?= $name; ?></a>
                    &nbsp;<button class="play2" rel="#mies2"><i class="icon-play"></i>
                        <div id="playlist" style="display:none;">
                            <a href="<?= $aurl; ?>">
                                <?= $name; ?>
                            </a>      
                        </div>
                    </button> <br/>
                    <?
                    break;
                default:
                    ?>
                    <a href="<?= $url; ?>"><?= $name; ?></a>

            <? endswitch; ?>
        <? endforeach; ?>
    <? endif; ?>
<? else: ?>
    <h3><?= Yii::t('common', "File not found"); ?></h3>
<? endif; ?>
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
<?
/*


  $key = $files[0]['Catalog']['id'];
  $play = '<a rel="video" id="autoclick' . $key . '" href="#video' . $key . '"><img rel="play" src="/img/play.gif" width="19" title="' . __('Watch online', true) . '" alt="' . __('Watch online', true) . '" onclick="switchPlay(this);" /></a>';
  $autoClick = '$("#autoclick' . $key . '").click();';
  if (empty($url)) {
  $name = __('Sorry. File is not accessible', true);
  $href = 'noref="noref"';
  $play = '';
  } else {
  $fileInfo = pathinfo(strtolower($urlFull));
  if (!empty($fileInfo['extension'])) {
  switch ($fileInfo['extension'])
  {

  case "mp4":
  $hideContent .= '<div id="video' . $key . '"><a style="width:640px; height:480px; display:block" id="ipad' . $key . '" onclick="return addMp4Video(' . $key . ', \'' . $urlFull . '\');"></a></div>';
  break;

  case "mkv":
  case "avi":
  $hideContent .= '<div id="video' . $key . '" style="width:640px; height:480px; overflow: hidden; " >
  <a onclick="return addAviVideo(' . $key . ', \'' . $urlFull . '\');"></a>
  <object id="videoobj' . $key . '" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="640" height="480" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">
  <param name="wmode" value="opaque" />
  <param name="autoPlay" value="true" />
  <param name="src" value="' . $urlFull . '" />
  <embed type="video/divx" src="' . $urlFull . '"	width="640" height="480" wmode="opaque" autoPlay="true" previewImage="" pluginspage="http://go.divx.com/plugin/download/">
  </embed>
  </object>
  </div>';
  break;
  default:
  $play = '';

  }
  } else {
  $play = '';
  }
  }
  echo '<p><a ' . $href . '>' . $name . '</a> ' . $app->sizeFormat($file['Catalog']['sz']) . ' ' . $play . '</p>';

  $str = __('Typically, this file also loaded with', true);
  }

  if (count($files) > 1) {
  echo'<h3>' . $str . '</h3><table cellspacing="3">';
  echo'<tr valign="middle">
  <td><a target="_blank" href="/catalog/meta/' . $file['Catalog']['group'] . '/0/1">' . __('All Files', true) . '</td>
  <td></td></tr>';
  foreach ($files as $f) {
  if ($f['Catalog']['id'] == $file['Catalog']['id']) {
  continue;
  }
  echo'<tr valign="middle"><td>';
  $urlFull = AppController::set_input_server($f['Catalog']['dir'] . '/' . $f['Catalog']['name'], false, $f['Catalog']['sgroup']);
  $url = '/catalog/load/' . $f['Catalog']['id'];
  $href = 'href="' . $url . '"';
  $name = $f['Catalog']['original_name'];
  if (strlen($name) > 40) {
  $part1 = substr($name, 0, 20);
  $part2 = substr($name, -20, 20);
  $name = $part1 . '...' . $part2;
  }
  $play = '<a rel="video" href="#video' . $key . '"><img rel="play" src="/img/play.gif" width="19" title="' . __('Watch online', true) . '" alt="' . __('Watch online', true) . '" onclick="switchPlay(this);" /></a>';
  if (empty($url)) {
  $name = __('Sorry. File is not accessible', true);
  $href = 'noref="noref"';
  $play = '';
  } else {
  $key = $f['Catalog']['id'];
  $fileInfo = pathinfo(strtolower($urlFull));
  if (!empty($fileInfo['extension'])) {
  switch ($fileInfo['extension']) {
  //*
  case "mp4":
  $hideContent .= '<div id="video' . $key . '"><a style="width:640px; height:480px; display:block" id="ipad' . $key . '" onclick="return addMp4Video(' . $key . ', \'' . $urlFull . '\');"></a></div>';
  break;
  // *//*
  case "mkv":
  case "avi":
  $hideContent .= '<div id="video' . $key . '" style="width:640px; height:480px; overflow: hidden; " >
  <a onclick="return addAviVideo(' . $key . ', \'' . $urlFull . '\');"></a>
  <object id="videoobj' . $key . '" classid="clsid:67DABFBF-D0AB-41fa-9C46-CC0F21721616" width="640" height="480" codebase="http://go.divx.com/plugin/DivXBrowserPlugin.cab">
  <param name="wmode" value="opaque" />
  <param name="autoPlay" value="true" />
  <param name="src" value="' . $urlFull . '" />
  <embed type="video/divx" src="' . $urlFull . '"	width="640" height="480" wmode="opaque" autoPlay="true" previewImage="" pluginspage="http://go.divx.com/plugin/download/">
  </embed>
  </object>
  </div>';
  break;
  default:
  $play = '';
  // *//*
  }
  } else {
  $play = '';
  }
  }
  echo '<a ' . $href . '>' . $name . '</a></td><td>' . $app->sizeFormat($file['Catalog']['sz']) . '</td><td>' . $play . '</tr>';
  }
  echo'</table>';
  }
  echo '<div style="display:none">' . $hideContent . '</div>';

  if (!$autoPlay)
  $autoClick = '';
  /*
  ?>

  <script type="text/javascript">
  <!--
  $(document).ready(function() {
  $("a[rel=video]").fancybox({
  'zoomSpeedIn':  0,
  'zoomSpeedOut': 0,
  'overlayShow':  true,
  'overlayOpacity': 0.8,
  'showNavArrows': false,
  'onComplete': function() { $(this.href + " a").trigger('click'); return false; }
  });
  <?php echo $autoClick; ?>
  });

  function addAviVideo(num, path)
  {
  //document.getElementById("video" + num).style.display="";
  //$("#videoobj" + num).trigger('click');
  return true;
  }

  function addMp4Video(num, path) {
  document.getElementById("ipad" + num).href=path;
  document.getElementById("video" + num).style.display="";
  $f("ipad" + num, "/js/flowplayer/flowplayer-3.2.5.swf",
  {plugins: {
  h264streaming: {
  url: "/js/flowplayer/flowplayer.pseudostreaming-3.2.5.swf"
  }
  },
  clip: {
  provider: "h264streaming",
  autoPlay: true,
  scaling: "fit",
  autoBuffering: true,
  scrubber: true
  },
  canvas: {
  backgroundGradient: "none",
  backgroundColor: "#000000"
  }
  }
  ).ipad();
  return false;
  }

  -->
  </script>
  <script type="text/javascript" src="/js/flowplayer/flowplayer-3.2.4.min.js"></script>
  <script type="text/javascript" src="/js/flowplayer/flowplayer.ipad-3.2.1.js"></script>
  <?php
  $javascript->link('jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack', false);
  $html->css('fancybox-1.3.4/jquery.fancybox-1.3.4', null, array(), false);
  $javascript->link('jquery.pngFix', false);
  $ret = '';
  if (count($files) <= 1)
  $ret = 'return false;';
  echo '
  <script type="text/javascript">
  <!--
  function switchPlay(cur)
  {
  ' . $ret . '
  $("a img[rel=play]").css({display: \'\'});
  cur.style.display="none";
  }

  -->
  </script>
  ';

  }
  else
  __("File not found");
  ?>
  <br />
 */
?>