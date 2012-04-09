<?
//echo $html->link('Тестирование', 'http://' . $_SERVER['HTTP_HOST'] . '/sitest.php') . '<br>';
//echo '<br>';
//echo $html->link('Оплата VIP', array('action'=>'index', 'controller' => 'pays', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Каталог файлов', array('action'=>'index', 'controller' => 'catalog', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Баннеры', array('action'=>'banners', 'controller' => 'utils', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Пользователи', array('action'=>'index', 'controller' => 'users', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Группы', array('action'=>'index', 'controller' => 'groups', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Права доступа', array('action'=>'acl', 'controller' => 'admin', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Права доступа(контроллеры)', array('action'=>'acl_controllers', 'controller' => 'admin', Configure::read('Routing.admin') => true)) . '<br>';
//echo '<br>';
//echo $html->link('Страницы', array('action'=>'index', 'controller' => 'pages', Configure::read('Routing.admin') => true)) . '<br>';

echo '<h3>Host</h3>';
echo '<p>' . $_SERVER["HTTP_HOST"] . '</p>';
echo '<h3>DETECTED ZONES '.$this->zone.'</h3>';
//echo '<p>' . checkAllowedMasks(Configure::read('Catalog.allowedIPs'), (empty($_SERVER["REMOTE_ADDR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"]), 1) . '</p>';
echo $zones_view;
echo '<h3>REMOTE_ADDR</h3>';
echo '<p>' . (isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : "empty") . '</p>';
echo '<h3>X-Forwarded-For</h3>';
echo '<p>' . (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : "empty") . '</p>';
echo '<h3>X-Real-Ip</h3>';
echo '<p>' . (isset($_SERVER["HTTP_X_REAL_IP"]) ? $_SERVER["HTTP_X_REAL_IP"] . ' (' . gethostbyaddr($_SERVER["HTTP_X_REAL_IP"]) . ')'  : "empty") . '</p>';
?>
<h3>View_ip =  <?=Yii::app()->user->getState('ip');?></h3>

<form method="post">
    <input name="view_ip" type="text"/>
</form>