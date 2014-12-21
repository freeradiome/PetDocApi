<?php
/**
 * 推倒查询词历史
 *
 */
class Tag_historys extends  Application{

	protected  $_tablename = 'tag_history'; //绑定数据库
	
	public function write($word,$uuid=''){
		
		return $this->add(array(
			'word'=>$word,
			'uuid'=>$uuid,
			'ip'=>get_client_ip(),
		));
	}
	

}
?>