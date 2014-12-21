<?php
/**
 * 幻灯广告
 *
 */
class Ads extends  Application{

	protected  $_tablename = 'app_ad'; //绑定数据库
	
	function info(){
		
		$info = $this->view(array(),array('id'=>'desc'),0,1);
		
		$json = array();
		if (  $info ){
			$articles =new articles();
			$json['id']=(int)$info['id'];
			$json['link']=$info['link'];
			$json['image']=$info['image'];
			$json['created_at'] = strtotime($info['created_at']);
			$json['article_info'] =$articles->article_info($info['source_id'],0);
		}
		return $json;
	}
	
}