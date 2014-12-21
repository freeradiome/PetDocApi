<?php 

/**
 * V9新闻评论数据索引表
 *
 */
class Commentsmore extends Application{

	protected  $_tablename = 'v9_comment'; //绑定数据库

	

	/**
	 * 建立新闻评论的索引
	 *
	 * @param int $news_id //新闻id
	 * @param int $siteid //站群id
	 * @param string $commentid //评论id串
	 * @return unknown
	 */
	function post($news_id,$siteid,$commentid,$title,$url){
		$have = $this->view(array('commentid'=>$commentid));
		if($have){
			$data=array(
			'anti'=>0,
			'neutral'=>0,
			'tableid'=>0,
			'display_type'=>0,
			'lastupdate'=>time()
			);
			if ( $this->increase(array('commentid'=>$commentid),array('total'=>1),false) ){
				$result = $this->update(array('commentid'=>$commentid),$data,false);
			}
		}else{
			$article = new articles();
			$article_info = $article->view(array('id'=>$news_id));
			$data = array(
			'siteid'=>$siteid,
			'commentid'=>$commentid,
			'title'=>$title,
			'url'=>$url,
			'total'=>1, //数据更新
			'tableid'=>0,
			// 以下参数当有值时候变为1
			'anti'=>0,
			'neutral'=>0,
			'tableid'=>0,
			'display_type'=>0,
			'lastupdate'=>time()
			//
			);
			$result = $this->add($data,false,false);
		}
		return $result;
		//http://sh.868.sc/test/index.php?m=content&c=index&a=show&catid=6&id=1
	}
}
?>