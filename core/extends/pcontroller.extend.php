<?php 
/**
 * 说明：需要验证的控制器基类(token失败后阻止数据输出)
 * 作者：RobertZeng <zeng444@163.com>
 * 日期：2011-10-12
 */
class pController extends Controller{
	
 
	public function filter(){
		parent::filter();
		parent::no_token_error();
	
	}


}
?>