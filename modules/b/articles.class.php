<?php
/**
 * V9新闻
 *
 */
class articles extends Application{

	protected  $_tablename = 'v9_news'; //绑定数据库

	/**
	 * 新闻列表
	 * 跳转贴 积分贴 投票贴  不显示 
	 * 权限分组贴 都显示
	 *
	 */
	function article_lists($start=0,$limit=20,$catid=array(),$keyword,$uid=0,$orderby=array()){
		if($start==0) $slide_list = $this->slide_list($catid,$uid);
		$condition = array();
		$condition['islink'] = '{ is not null }';
		$condition['posids'] = 0;
		//		$condition['groupids_view'] = '{ is not null }';
		if( $keyword ) {
			$condition['title'] = "{ like '%$keyword%' }";
		}
		if( $catid ){
			$str = implode(',',$catid);
			$condition['catid'] = ' { in ('.$str.') }';
		}

		$count = $this->count($condition);
		$is_end = ($count > $start+$limit ) ?  0 :1;
		
		$orderby = ( $orderby ) ? $orderby: array('id'=>'desc');
		$result = $this->items('id,title,description,username,inputtime,updatetime,thumb')->lists($condition,$orderby,$start,$limit);
		$data = array();
		$vnewsdatas = new articledatas();
		$comments = new Comments();
		$favarites =  new favarites();
		foreach ($result as $k=>$v){
			$content = $vnewsdatas->items('content,readpoint,voteid,allow_comment')->view(array('id'=>$v['id']));
			if($content['readpoint']==0 && $content['voteid']==0  ){ //投票贴积分贴不显示
				$data[$k]['id']          = intval($v['id']);
				$data[$k]['title']       = $v['title'];
				$data[$k]['ctype']       = 1;
				$data[$k]['is_favorit']   =(  $favarites->is_favorite($uid, $v['id'],1) ) ? 1:0;
				$data[$k]['is_slide'] = 0;
				$data[$k]['thumb_picture_url'] = ($v['thumb'])?$v['thumb']:null;
				//				$data[$k]['is_slide'] = 0;
				//				$data[$k]['thumb_picture_url'] = 'http://www.lpfwpt.org/upload/app/news/46a6903c7a18397c323b2938ca836fd4.gif';
				$data[$k]['comment_count'] = $comments->commnent_number($v['id']);

				$data[$k]['description'] = $v['description'];
				$data[$k]['created_at']  = intval($v['updatetime']);
				$data[$k]['allow_comment']   = ( $content['allow_comment'] ==1) ?1:0;
				$data[$k]['html_content']    = $this->tpl($data[$k]['title'] ,$data[$k]['created_at'],$content['content'] );
			}
		}

		return array(
		'is_end'=>$is_end,
		'data'=>($start==0) ?array_merge($slide_list,$data):$data
		);

	}

	/**
	 * 幻灯图片列表
	 *
	 * @param int $catid
	 * @param int $uid
	 * @return array
	 */
	function slide_list($catid=array(),$uid){
		$position  = new Positions();
		$lists = $position->slide_lists($catid);
		$data = array();
		foreach ($lists as $k=>$v){
			$data[$k] =  $this->article_info($v['id'],$uid);
			$array = String2Array($v['data']);
			$data[$k]['thumb_picture_url'] =  (isset($array['thumb']))?$array['thumb']:'';
			$data[$k]['is_slide'] = 1;
		}
		return $data;
	}
	/**
	 * 单条新闻
	 *
	 * @param int $id
	 * @return array
	 */
	function article_info($id,$uid){
		$condition = array();
		$condition['islink'] = '{ is not null }';
		$condition['id'] =$id;
		$v = $this->view($condition);
		$comments = new Comments();
		$result = array();
		$vnewsdatas = new articledatas();
		$favarites =  new favarites();
		if($v ){
			$content = $vnewsdatas->items('content,readpoint,voteid,allow_comment')->view(array('id'=>$v['id']));
			$result['id']          = intval($v['id']);
			$result['ctype']       = 1;
			$result['is_favorit']   =(  $favarites->is_favorite($uid, $v['id'],1) ) ? 1:0;
			$result['title']       = $v['title'];
			$result['is_slide'] = 0;
			$result['thumb_picture_url'] = null;
			$result['comment_count'] = $comments->commnent_number($v['id']);
			$result['description'] = $v['description'];
			$result['allow_comment']   = ( $content['allow_comment'] ==1) ?1:0;
			$result['created_at']  = intval($v['updatetime']);
			$result['html_content']    = $this->tpl($v['title'] ,$result['created_at'],$content['content']  );
		}
		return $result;
	}

	/**
	 * 生成页面模版
	 *
	 * @param string $title
	 * @param datetime $created_at
	 * @param string $content
	 * @return string
	 */
	private function tpl($title,$created_at,$content){
		return  '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />  
				<title>'.$title.'</title>
				<style type="text/css">
				body{padding:0px;margin:0px;background:#EFEFEF}
				article{display:block;padding:20px;}
				h1{padding:0px;margin:0px;font-size:18px;text-align:center;color:#333}
				article .content{font-size:14px;line-height:24px;}
				.date{text-align:center;font-size:11px;color:#7b7b7b;margin:12px 0px;}
				.date span{margin-right:1em}
				article .content p{margin:8px 0px}
				article .content img{width:260px;height:auto;display:block;margin:0px auto}
				</style>
				</head>
				<body>
				<article>
				<h1>'.$title.'</h1>
				<div class="date">
				<span>时间：'.date('Y-m-d H:i:s',$created_at).' </span>
				</div>
				<div class="content">'.strip_rss_tags($content).'</div>
				</article>
				</body>
				</html>';
	}

}
?>