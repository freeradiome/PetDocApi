<?php
/**
 * V9供求信息more
 *
 */
class Tradedata extends Application{

	protected  $_tablename = 'v9_yp_buy_data'; //绑定数据库

	public $_validate = array(
	'content'=>array('xss'=>false)
	);

}