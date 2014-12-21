<?php
/**
 * 搜索记录
 *
 */
class History extends Controller{

	protected  $_limit = 20;
	
	/**
	 * 读取历史记录
	 *
	 */
	function lists(){
		
		$word = trim( _g('word') );
		
		if(!$word){
			$this->get_params_error('联想词空!');
		}
		
		$limit = intval( _g('limit'));
		$limit = ($limit)?$limit:$this->_limit;
		$history = new Historys();
		
		$list = $history->think_list($word,$limit);
		
		$this->sucess($list);
	}

	/**
	 * 获取热门词
	 */
	function hot(){
		$history = new Historys();
		$list = $history->hot_list(12);
		$this->sucess($list);
	}

	/**
	 * 刷新一个记录
	 *
	 */
	function touch(){
		$word = trim( _g('word') );
		if(!$word){
			$this->get_params_error('联想词空!');
		}
		$history = new Historys();
		$result = $history->touch($word);
		$this->sucess($result);
	}

}
