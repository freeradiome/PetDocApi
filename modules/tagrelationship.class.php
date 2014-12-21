<?php
/**
 * 疾病症状关系模型
 *
 */
class Tagrelationship extends  Application{
	
	protected  $_tablename = 'tagall'; //绑定数据库
	
	/**
	 * 获取某个指定疾病下的症状
	 *
	 * @param string $ill_id
	 */
	function tag_lists($ill_id,$number=100){
		$sql = "SELECT tagall_name,COUNT(tagall_id)  AS `count` FROM {$this->_tablename} WHERE tagall_ill=$ill_id AND tagall_type=0
			GROUP BY tagall_name
			ORDER BY COUNT DESC limit $number";
		
		return $this->_db->getAll($sql);
	}

}
	
