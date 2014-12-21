<?php
/**
 * V9新闻评论数据
 *
 */
class Comments extends Application{

	protected  $_tablename = 'v9_comment_data_1'; //绑定数据库

	public $_site_id = 1; //站群id

	/**
	 * 评论数
	 *
	 * @param int $news_id
	 * @return array
	 */
	function commnent_number($news_id){
		$article = new articles();
		$article_info = $article->view(array('id'=>$news_id));
		$commentid = $this->generate_comment_id($article_info['catid'],$article_info['id']);
		$commentsmore = new Commentsmore();
		$result = $commentsmore->view(array('commentid'=>$commentid));
		return intval($result['total']);
	}

	/**
	 * 提交一条评论信息
	 *
	 * @param int $news_id 新闻id
	 * @param string $content //正文内容
	 * @param string $token //发表的用户token
	 * @return int 插入id
	 */
	public function  post($news_id,$content,$token){

		$article = new articles();
		$article_info = $article->view(array('id'=>$news_id));
		if($article_info ) {
			$site_id = $this->_site_id;
			$commentid = $this->generate_comment_id($article_info['catid'],$article_info['id']);
			$Commentsmore = new Commentsmore();

			$Commentsmore->post($article_info['id'],$site_id,$commentid,$article_info['title'],$article_info['url']);

			$accessTokens = new accessTokens();

			$userinfo = $accessTokens->info($token);

			$data = array(
			'commentid'=>$commentid,
			'content'=>$content,
			'siteid'=>$site_id,
			'userid'=>$userinfo['userid'],
			'username'=>$userinfo['username'],
			'creat_at'=>time(),
			'ip'=>get_client_ip(),
			'status'=>1, //状态1为通过
			'direction'=>1, //正面
			'support'=>0, //正面
			'reply'=>0, //正面
			);
			if( $this->add($data,false,false) ){
				return 1;
			}
		}
	}

	/**
	 * 通过用户ID获取评论过的帖子和评论列表
	 *
	 * @param int $uid
	 * @return array
	 */
	function get_user_lists($uid){
		$comments = new Comments();
		$sql = "SELECT
		b.commentid,b.title,b.total
		FROM
		  v9_comment_data_1 AS a
		INNER JOIN
		v9_comment  AS b
		ON a.commentid=b.commentid
		WHERE a.userid = $uid 
		GROUP BY a.commentid 
		LIMIT 0,10";
		$lists = $this->_db->getAll($sql);
		$json = array();
		$articles = new articles();
		foreach ($lists as $k=>$v){
			$commentid_arr = explode('-',$v['commentid']);
			$ainfo = $articles->article_info($commentid_arr[1],$uid);
			$json[$k]['id'] = $ainfo['id'];
			$json[$k]['title'] =  $ainfo['title'];
			$json[$k]['is_slide'] =  $ainfo['is_slide'];
			$json[$k]['thumb_picture_url'] =  $ainfo['thumb_picture_url'];
			$json[$k]['description'] =  $ainfo['description'];
			$json[$k]['created_at'] =  $ainfo['created_at'];
			$json[$k]['allow_comment'] =  $ainfo['allow_comment'];
			$json[$k]['html_content'] =  $ainfo['html_content'];
			$json[$k]['comment_count'] = $ainfo['comment_count'];
			$json[$k]['comment_lists'] = $this->get_user_comment($uid,$v['commentid']);
		}
		return $json;
	}

	/**
	 *  获取用户评论
	 *
	 * @param int $uid 用户ID
	 * @param string $comment_id 评论ID串
	 * @return array
	 */
	public function get_user_comment($uid,$comment_id){
		return $this->items('id,username,userid,creat_at as created_at,content')->lists(array('userid'=>$uid,'commentid'=>$comment_id,'status'=>1));
	}

	/**
	 * 获取评论列表
	 *
	 * @param int $news_id
	 * @param int $start
	 * @param int $limit
	 * @return array
	 */
	public function  get_lists($news_id,$start,$limit){

		$article = new articles();
		$article_info = $article->view(array('id'=>$news_id));

		$comments = new Comments();
		$count = $comments->commnent_number($news_id);
		$is_end = ($count > $start+$limit ) ?  0 :1;

		if($article_info){
			$commentid = $this->generate_comment_id($article_info['catid'],$article_info['id']);
			$comment_lists = $this->lists(array('commentid'=>$commentid),array('creat_at'=>'desc'),$start,$limit);
			$result = array();
			foreach ($comment_lists as $k=>$v){
				$result[$k]['id'] = $v['id'];
				$result[$k]['username'] = $v['username'];
				$result[$k]['usericon'] = 'http://sh.868.sc/rest/public/images/icon.jpg';
				$result[$k]['created_at'] = $v['creat_at'];
				$result[$k]['content'] = $v['content'];
			}
			return array(
			'is_end'=>$is_end,
			'data'=>$result
			);
		}


	}

	/**
	 * 生成v9comment_id
	 *
	 * @param int $$catid 分类id
	 * @param int $news_id 新闻id
	 * @return string
	 */
	private function  generate_comment_id($catid,$news_id){
		return 'content_'.$catid.'-'.$news_id.'-'.$this->_site_id;
	}

}
?>