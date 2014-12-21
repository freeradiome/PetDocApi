<?php
/**
 * 推送信息模型
 *
 */
class Messages extends Application{

	protected  $_tablename = 'app_push_messages'; //绑定数据库

	/**
	 * 获取最新一条推送
	 *
	 * @param int $last_id
	 * @param int $duty
	 * @return array
	 */
	public function get($last_id,$duty){
		$list =$this->lists(array('duty'=>$duty,'id'=>"{ >$last_id  }"),array('id'=>'desc'),0,1);
		$data = array();
		if( $list )	{
			$articles = new articles();
			$info = $articles->article_info( $list[0]['source_id'],0 );
			if( $info ){
				$data['id'] = $list[0]['id'];
				$data['title'] = $list[0]['title'];
				$data['created_at'] = strtotime($list[0]['created_at']);
				$data['description'] = $list[0]['description'];
				$data['article_info'] = $info;
			}
		}
		return $data;
	}

}
?>