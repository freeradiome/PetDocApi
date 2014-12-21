<?php
/**
 * app的认证会话凭证
 *
 */
class Tagstypes extends  Application{
	
	protected  $_tablename = 'tagstype'; //绑定数据库
	
	/**
	 * 获取疾病分类
	 *
	 * @return unknown
	 */
	function cat_list(){
		return $this->items('tagstype_id as id,short_name as name')->lists(array(),array('tagstype_desc'=>'asc'),0,100);
	}
}

?>