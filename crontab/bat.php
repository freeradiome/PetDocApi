<?php
/**
 * 百度蜘蛛服务
 *
 */
define('CRON_PATH', str_replace('crontab/bat.php', '', str_replace('\\', '/', __FILE__)));
require(CRON_PATH.'config/global.config.php');
require(CRON_PATH.'core/init.php');
require(CRON_PATH.'config/cron.config.php');

$route = new Route(array(
	'pathinfo'=>pathinfo,
	'class'=>'bat',
//	'method'=>'testbug'
	'method'=>'combat'
//	'method'=>'user_flat'
));

$route->go();
?>
