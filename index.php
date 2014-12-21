<?php
require('config/global.config.php');
require('core/init.php');
require('config/app.config.php');
$route = new Route(array(
	'pathinfo'=>pathinfo,
	'class'=>'version',
	'method'=>'info'
));
$route->go();
?>