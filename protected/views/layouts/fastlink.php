<html>
    <head>

        <link rel="stylesheet" type="text/css" href="/css/global.css" />

        <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
        <?php
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerCoreScript('jquery.cookie');
        Yii::app()->getClientScript()->registerScriptFile('/js/jquery.form.js');


        Yii::app()->clientScript->registerScriptFile('/js/flowplayer-3.2.8.min.js');
        Yii::app()->clientScript->registerScriptFile('/js/jquery.tools.min.js');
        Yii::app()->clientScript->registerScriptFile('/js/jquery.placeholder.min.js');
        Yii::app()->clientScript->registerScriptFile('/js/flowplayer.playlist-3.2.8.min.js');
        Yii::app()->clientScript->registerScriptFile('/js/flowplayer.ipad-3.2.8.min.js');
        ?>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <?php
        $userRole = Yii::app()->user->getState('role');
        if (empty($metaExpires)) {
            //определяем последнюю пятницу
            $dayOfWeek = date('w');
            $difDay = $dayOfWeek - 5;
            if ($difDay < 0) {
                $difDay += 7;
            }
            $lastFri = mktime(20, 0, 0, date('m'), date('d') - $difDay, date('Y'));
            $metaExpires = date('r', $lastFri);
        }
        //echo '<meta http-equiv="expires" content="' . $metaExpires . '" />';

        if (empty($metaRobots)) {
            $metaRobots = 'INDEX, FOLLOW';
        }

        //$aliasUrl = Configure::read('App.aliasUrls');
        //$siteName = Configure::read('App.siteName');
        ?>
        <meta name="Robots" content="<?php //echo $metaRobots;         ?>" />
        <meta name="keywords" content="<?php //echo $siteName; //if (isset($metaKeywords)) echo $metaKeywords;          ?>" />
        <meta name="description" content="<?php //echo $siteName; //if (isset($metaDescription)) echo $metaDescription;          ?>" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    </head>    
    <body>
    <center>
        <?php
        /*
          if (isset($authUserGroups) && in_array(Configure::read('VIPgroupId'), $authUserGroups))
          {
          //ДЛЯ ВИПОВ БЛОК С БАННЕРАМИ ВЫРЕЗАЕМ
          foreach ($blockContent as $bi => $b)
          {
          if (is_array($b) && count($b) > 0)
          {
          foreach($b as $key => $value)
          {
          if (strpos($value['title'], 'banner') !== false)
          {
          unset($blockContent[$bi][$key]);
          }
          }
          }
          }
          }
         * 
         */
        ?>
        <div id="topline"><center>
                <?php
//if (isset($authUserGroups) && in_array(Configure::read('VIPgroupId'), $authUserGroups)) {
//else {

                //echo $BlockBanner->getBanner('header');                
                echo CFLBanners::model()->getBanner('header');
                ?>
<!-- MarketGidComposite Start -->
 <div id="MarketGidScriptRootC42771">
  <div id="MarketGidPreloadC42771">
   <a id="mg_add42771" href="http://usr.marketgid.com/demo/goods/" target="_blank">Добавить свое объявление</a><br> <a href="http://marketgid.com/" target="_blank">Загрузка...</a> 
    </div>
     <script> 
      (function(){
       var D=new Date(),d=document,b='body',ce='createElement',ac='appendChild',st='style',ds='display',n='none',gi='getElementById';
        var i=d[ce]('iframe');i[st][ds]=n;d[gi]("MarketGidScriptRootC42771")[ac](i);try{var iw=i.contentWindow.document;iw.open();iw.writeln("<ht"+"ml><body></body></ht"+"ml>");iw.close();var c=iw[b];}
         catch(e){var iw=d;var c=d[gi]("MarketGidScriptRootC42771");}var dv=iw[ce]('div');dv.id="MG_ID";dv[st][ds]=n;dv.innerHTML=42771;c[ac](dv);
          var s=iw[ce]('script');s.async='async';s.defer='defer';s.charset='utf-8';s.src="http://jsc.dt00.net/f/a/fastlink.ws.42771.js?t="+D.getYear()+D.getMonth()+D.getDate()+D.getHours();c[ac](s);})();
           </script>
            </div>
             <!-- MarketGidComposite End -->
            </center></div>
        <div id="head">
            <div class="authorisation">
                <?php
//if (!empty($authUser['userid']))
//{
//echo __("Hi", true) . ', ' . $authUser['username'] . '! <a href="/users/logout">' . __("Log out", true) . '</a>';
//}
//else {
                ?>
                <?php if (Yii::app()->user->isGuest): ?>
                    <?= Yii::t('common', 'Auth'); ?> | <a href="/users/register"><?= Yii::t('common', 'Register'); ?></a>
                    <form id="top_auth" name="auth" method="post" action="/users/login" onSubmit="userLogin();return false;">
                        <input name="FLFormLogin[username]" type="text" size="40" placeholder="<?= Yii::t('user', 'Username');?>" />
                        <input name="FLFormLogin[password]" type="password" size="40" onKeyPress="return submitenter(this,event);"; placeholder="<?= Yii::t('user', 'Password');?>" />
                        <input type="submit" style="visibility: hidden;"/>
                    </form>
                <?php else: ?>
                    <h4><i class="icon-user"></i> <?= Yii::app()->user->name; ?> <a href="/catalog/user"?><i class="icon-file"></i> <?=Yii::t('common','My files');?></a>
                    <?php if($userRole=="admin"):?>
                        <a href="/admin"?>Admin</a>
                    <?php endif;?>
                        <br/>
                        IP: <?= $this->ip; ?>
                    </h4><button  class="btn" name="logout" onClick="$.post('/users/exit',{exit:1},function(){window.location.reload();});"><?= Yii::t('common', 'Logout'); ?>
                    </button>

                <?php endif; ?>

            </div>
            <div class="logo"><a href="/" title="<?= Yii::t('common', 'Home'); ?>"></a></div>

            <div class="search">
                <?= Yii::t('common', 'Search'); ?>
                <form name="searchform" id="searchform" method="post" action="/catalog/search/" onSubmit="userSearch(this);return false;">
                    <input name="searchvalue" type="text" size="120" placeholder="<?= Yii::t('common', 'Search for file'); ?>..."/>

                </form>
            </div>
        </div>
        <div id="middle">
            <div class="left_ad">
                <?php
                /*
                  if (isset($authUserGroups) && in_array(Configure::read('VIPgroupId'), $authUserGroups))
                  {
                  }
                  else
                  { */
                echo CFLBanners::model()->getBanner('left');

                /* } */
                ?>

            </div>
            <div class="center_block">
                <? echo $content; ?>
            </div>
            <div class="right_ad">
                <? echo CFLBanners::model()->getBanner('right'); ?>
            </div>
        </div>
        <div id="bottom_ad">
            <div class="bottom_ad1">
                <? echo CFLBanners::model()->getBanner('bottom1'); ?>
            </div>
            <div class="bottom_ad1">
                <? echo CFLBanners::model()->getBanner('bottom2'); ?>
                
            </div>
        </div>
        <div id="bottom_copy">
            <div>
                &copy;&nbsp;<?php echo date('Y'); ?>&nbsp;&mdash; <a href="<?= Yii::app()->request->getBaseUrl(true); ?>"><?= Yii::app()->request->getBaseUrl(true); ?></a>
                |
                email: <a href="mailto:<?= Yii::app()->params['supportEmail']; ?>"><?= Yii::app()->params['supportEmail']; ?></a>
                |
                <a href="/pages/reklama"><?= Yii::t('common', 'Advertisement'); ?></a>
                |
                <a href="/pages/contacts"><?= Yii::t('common', 'Contacts'); ?></a>
                |
                <a href="/pages/pravo"><?= Yii::t('common', 'For holders'); ?></a>
            </div><br />
            <!--LiveInternet counter--><script type="text/javascript"><!--
                document.write("<a href='http://www.liveinternet.ru/click' "+
                    "target=_blank><img src='//counter.yadro.ru/hit?t14.11;r"+
                    escape(document.referrer)+((typeof(screen)=="undefined")?"":
                    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                    ";"+Math.random()+
                    "' alt='' title='LiveInternet: показано число просмотров за 24"+
                    " часа, посетителей за 24 часа и за сегодня' "+
                    "border='0' width='88' height='31'><\/a>")
                //--></script><!--/LiveInternet-->
        </div>
    </center>
    <script language="javascript">
        <!--
        function userLogin(){
            $(this).ajaxSubmit(function(){
            
            });
            return false;
        }
        var search = $('#searchform input');
            
        function userSearch(){            
            search_text = search.val();
            if(search_text != undefined)
                window.location='/catalog/search?search_opt=bytitle&text='+search_text;
            //$('.center_block').load('/catalog/search/bytitle/'+search_text);
        }

        $(function(){
            $('input[placeholder], textarea[placeholder]').placeholder();
        });

        function submitenter(myfield,e)
        {
            var keycode;
            if (window.event) keycode = window.event.keyCode;
            else if (e) keycode = e.which;
            else return true;

            if (keycode == 13)
            {
                myfield.form.submit();
                return false;
            }
            else
                return true;
        }
        //-->
        
        
    
    </script>
    <script type="text/javascript">document.write("<scr" + "ipt type='text/javascr"+"ipt' src='http://js.rmbn.net/ads.js?sid=9495&p="+Math.random()+"'></scr"+"ipt>");</script>
</body>
</html>