<?php
/**
 * V9供求信息
 *
 */
class Trade extends Application{

	protected  $_tablename = 'v9_yp_buy'; //绑定数据库

	//默认产品发布的到期时间/天
	private $_product_expire_day = 30;

	private $_upload_path='uploadfile/';
	//审核状态
	private $_product_checked = 99; //1为等审核 99审核通过;

	//供求图片缩略
	private $_img_width_size =500;

	public $_validate = array(
	'thumb'=>array('xss'=>false),
	'url'=>array('xss'=>false),
	);

	/**
	 * 通过UID获取发布的供求信息
	 *
	 * @param int $uid
	 * @param int $start
	 * @param int $limit
	 * @return array
	 */
	public function user_product_lists($uid,$start=0,$limit=20){


		$condition = array();
		$condition['userid'] = $uid;
		$count = $this->count($condition);
		$is_end = ($count > $start+$limit ) ?  0 :1;
		$result = $this->items('id,title,thumb,tid,inputtime')->lists($condition,array('id'=>'desc'),$start,$limit);
		$data = array();
		$Tradedata = new Tradedata();
		$favarites =  new favarites();
		foreach ($result as $k=>$v){
			$data[$k]['id'] = (int)$v['id'];
			$data[$k]['ctype']       = 2;
			$data[$k]['is_slide'] = 0;
			$data[$k]['type'] = (int)$v['tid'];
			$data[$k]['is_favorit'] =  (  $favarites->is_favorite($uid, $v['id'],2) ) ? 1:0;
			$data[$k]['thumb_picture_url'] = ($v['thumb'])? $v['thumb'] : null;
			$data[$k]['title'] = $v['title'];
			$data[$k]['created_at'] =$v['inputtime'];
			$content = $Tradedata->items('content')->view(array('id'=>$v['id']));

			$data[$k]['description'] = strip_tags($content['content']);
			$data[$k]['html_content']    = $this->tpl($v['title'] ,$data[$k]['created_at'],$content['content'],$v['thumb'] );
		}
		return array(
		'is_end'=>$is_end,
		'data'=>$data
		);
	}



	/**
	 * 交易信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function trade_info($id,$uid=0){
		$v = $this->view(array('id'=>$id));
		$data = array();
		$Tradedata = new Tradedata();
		$favarites =  new favarites();
		if($v){
			$data['id'] = $v['id'];
			$data['title'] = $v['title'];
			$data['ctype']  = 2;
			$data['is_favorit'] =  (  $favarites->is_favorite($uid, $v['id'],2) ) ? 1:0;
			$data['is_slide'] = 0;
			$data['type'] = (int)$v['tid'];
			$data['thumb_picture_url'] = ($v['thumb'])? $v['thumb'] :null;
			$data['created_at'] =$v['inputtime'];
			$content = $Tradedata->items('content')->view(array('id'=>$v['id']));
			$data['description'] = strip_tags($content['content']);
			$data['html_content']    = $this->tpl($v['title'] ,$data['created_at'],$content['content'],$data['thumb_picture_url'] );
		}
		return $data;
	}

	/**
	 * 获取供求信息列表
	 *
	 * @param int $type  类型 1、出售 2、求购
	 * @param int $catid  分类ID 不填写时读取全部
	 * @param int $start 起点 默认0
	 * @param int $limit 条数 默认20
	 * @return array
	 */
	public function product_lists($type=1,$catid=0,$uid=0,$start=0,$limit=20){
		if($start==0)   $slide_list = $this->slide_list($catid,$uid);
		$condition = array();
		$condition['posids'] = 0;
		$condition['tid'] = $type;
		if($catid){
			$condition['catid'] = $catid;
		}

		$count = $this->count($condition);
		$is_end = ($count > $start+$limit ) ?  0 :1;
		$result = $this->items('id,title,tid,thumb,inputtime')->lists($condition,array('id'=>'desc'),$start,$limit);

		$data = array();
		$Tradedata = new Tradedata();
		$favarites =  new favarites();
		foreach ($result as $k=>$v){

			$data[$k]['is_slide'] = 0;
			$data[$k]['thumb_picture_url'] = ($v['thumb'])? $v['thumb'] : null;
			$data[$k]['id'] = $v['id'];
			$data[$k]['title'] = $v['title'];
			$data[$k]['type'] = $v['tid'];
			$data[$k]['is_favorit'] =  (  $favarites->is_favorite($uid, $v['id'],2) ) ? 1:0;
			$data[$k]['ctype']  = 2;
			$data[$k]['created_at'] =$v['inputtime'];
			$content = $Tradedata->items('content')->view(array('id'=>$v['id']));
			$data[$k]['description'] = strip_tags($content['content']);
			$data[$k]['html_content']    = $this->tpl($v['title'] ,$data[$k]['created_at'],$content['content'],$data[$k]['thumb_picture_url'] );
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
		$lists = $position->slide_lists($catid,'yp');
		$data = array();
		foreach ($lists as $k=>$v){
			$data[$k] =  $this->trade_info($v['id'],$uid);
			$array = String2Array($v['data']);
			$data[$k]['thumb_picture_url'] = (isset($array['thumb']))?$array['thumb']:'';
			$data[$k]['is_slide'] = 1;
		}
		return $data;
	}

	/**
	 * 获取供求信息列表
	 *
	 * @param int $id 不填写为获取所有
	 * @return array
	 */
	public function category($id=0){
		$cate = new Categorys();
		$conditon = array();
		$conditon['module']='yp';
		$conditon['modelid']=19;
		$conditon['parentid']=0;
		if($id){
			$conditon['catid']=$id;
			return $cate->items('catid,catname')->view($conditon);
		}else{
			return  $cate->items('catid,catname')->lists($conditon,array(),0,100);
		}

	}

	/**
	 * 发布供应信息
	 *
	 * @param string $title 标题
	 * @param int $catid 分类id
	 * @param int $price 价格
	 * @param string $content 内容
	 * @param string $thumb 缩略图
	 * @param string $token 发布者token
	 * @return bool
	 */
	function sale($title,$catid,$price,$content,$thumb,$token){
		return $this->post($title,$catid,1,$price,$content,$thumb,$token);
	}

	/**
	 * 发布求购信息
	 *
	 * @param string $title 标题
	 * @param int $catid 分类id
	 * @param int $price 价格
	 * @param string $content 内容
	 * @param string $thumb 缩略图
	 * @param string $token 发布者token
	 * @return bool
	 */
	function buy($title,$catid,$price,$content,$thumb,$token){
		return $this->post($title,$catid,2,$price,$content,$thumb,$token);
	}
	/**
	 * 生成附件名
	 *
	 * @param string $fileext 后缀名
	 * @return string
	 */
	private function getfilename($fileext){
		return date('Ymdhis').rand(100, 999).'.'.$fileext;
	}

	/**
	 * 上传图片并返回路径
	 *
	 * @param string $file 控件信息
	 * @return string
	 */
	private function upload_thumb($file){

		$image = new Image();
		$image->input_name=$file;
		$image->file_size=20971520;
		$fd= $this->_upload_path.date('Y/md/');
		$image->save_path = SH_PATH.$fd;
		if(!file_exists($image->save_path)){
			@mkdir($image->save_path,0777);
		}
		$pathinfo = pathinfo($_FILES[$file]['name']);
		$image->savefile_name = $this->getfilename($pathinfo['extension']);
		$result =  $image->upfile() ;

		if( $result==1 ){
			$thinkImage = new ThinkImage(THINKIMAGE_GD,$image->save_path.$image->savefile_name);
			$width = $thinkImage->height();
			$height = $thinkImage->width();
			$pos = $height/$width;
			$thinkImage->thumb($this->_img_width_size, intval( $this->_img_width_size*$pos ) )->save($image->save_path.$image->savefile_name);
			return PUBLIC_ROOT.$fd.$image->savefile_name;
		}
	}

	/**
	 * 删除供求
	 *
	 * @param int $id 删除供求
	 * @param string $token
	 * @return array
	 */
	function remove($id,$token){
		$user_info = $this->is_chekced_user($token);
		if( !$user_info ){
			return -1;
		}


		$result = $this->delete(array('userid'=>$user_info['userid'],'id'=>$id));

		if($result){
			$favarites = new Favarites();
			$favarites->delete(array('sid'=>$id,'type'=>2));
		}
		return $result;
	}
	/**
	 * 供求发布
	 *
	 * @param string $title 标题
	 * @param int $catid 分类id
	 * @param int $posttype  提交类型 1为供应 2为求购
	 * @param int $price 价格
	 * @param string $content 内容
	 * @param string $thumb 缩略图
	 * @param string $token 发布者token
	 * @return bool
	 */
	private function post($title,$catid,$posttype,$price,$content,$thumb,$token){
		$user_info = $this->is_chekced_user($token);

		if( !$user_info ){
			return -1;
		}
		//		if( !$this->category($catid) ){
		//			return -2;
		//		}
		//处理图片
		if( $thumb ){
			$thumb = $this->upload_thumb($thumb);
			if(!$thumb) {
				return -3;
			}
		}
		$data = array(
		'tid'=>$posttype,
		'catid'=>$catid,
		'typeid'=>'0',
		'title'=>$title,
		'style'=>'',
		'thumb'=>$thumb,
		'keywords'=>'',
		'description'=>'',
		'price'=>$price,
		'posids'=>'0',
		'listorder'=>'0',
		'status'=>$this->_product_checked, //审核状态
		'sysadd'=>'0',
		'userid'=>$user_info['userid'],
		'username'=>$user_info['username'],
		'inputtime'=>time(),
		'updatetime'=>time(),
		'elite'=>'1',
		'areaid'=>'0',
		'expiration'=>time()+$this->_product_expire_day*86400,
		);

		if( $this->add($data,false,false) ){
			$result = $this->update(array('id'=>$this->_last_insert_id),array('url'=>PUBLIC_ROOT."index.php?m=yp&c=index&a=show&catid=$catid&id=".$this->_last_insert_id),false );
			$data_more = array(
			'id'=>$this->_last_insert_id,
			'content'=>$content,
			'paginationtype'=>'0',
			'maxcharperpage'=>'0',
			'standard'=>'',
			'addition_field'=>'',
			'brand'=>'',
			'yieldly'=>'',
			'units'=>'个'
			);
			$Tradedata =  new Tradedata();
			return $Tradedata->add($data_more,false,false);
		}
	}

	/**
	 * 是否经过验证的商户
	 *
	 * @param string $token 用户token
	 * @return array 返回用户信息
	 */
	public  function is_chekced_user($token){
		$accessTokens = new accessTokens();
		$token_info = $accessTokens->info($token);
		if( $token_info ){
			$company  = new Companys();
			if( $company->is_checked($token_info['userid']) ){
				return  array(
				'userid'=>$token_info['userid'],
				'username'=>$token_info['username']
				);
			}
		}

	}

	/**
	 * 生成页面模版
	 *
	 * @param string $title
	 * @param datetime $created_at
	 * @param string $content
	 * @return string
	 */
	private function tpl($title,$created_at,$content,$image){

		$image_div =  ($image) ? '<div class="image"><img src="'.$image.'"></div>':'';
		$html =  '<html>
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
				article .content img,div.image img{width:260px;height:auto;display:block;margin:0px auto}
				</style>
				</head>
				<body>
				<article>
				<h1>'.$title.'</h1>
				<div class="date">
				<span>时间：'.$created_at.' </span>
				</div>
				'.$image_div.'
				<div class="content">'.strip_rss_tags($content).'</div>
				</article>
				</body>
				</html>';
		return $html;
	}


}