<?php
/**
 * v9单页模型(商会介绍)
 *
 */
class Pages extends Application{

	protected  $_tablename = 'v9_page'; //绑定数据库
	
	private $_cat_id = array(
		'intro' => 2
	);
	
	/**
	 * 商会介绍
	 *
	 * @return array
	 */
	function intro(){
	
		 $info = $this->view(array( 'catid'=>$this->_cat_id[__FUNCTION__]) );
		 return array(
		 	'id'=>$info['catid'],
		 	'title'=>$info['title'],
		 	'content'=>$info['content']
		 );
	}

}
?>