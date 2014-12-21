<?php
/**
 * V9产品信息
 *
 */
class Products extends Application{

	protected  $_tablename = 'v9_yp_product'; //绑定数据库

	/**
	 * 推荐产品
	 *
	 * @return unknown
	 */
	public function recommand_lists($start=0,$limit=20){

		$condition = array();
		$condition['elite']=1;
		$condition['status']=1;
		$count = $this->count($condition,'userid');
		$is_end = ($count > $start+$limit ) ?  0 :1;
		//
		$slide = array(
		'http://www.lpfwpt.org/upload/app/slide/e67e75c4e20c71cc0e7e23c0e6aafba5.jpg',
		'http://www.lpfwpt.org/upload/app/slide/dac66ebb9e66cfa9eb3328cc939d4dab.gif',
		'http://www.lpfwpt.org/upload/app/slide/ff1afb8018d88cf7a5b462556ef6e20c.gif',
		'http://www.lpfwpt.org/upload/app/slide/3fef96fe19b2731cdbc312c867ef972c.gif'
		);
		$index = 0;
		$data = array();
		//
		$result = $this->lists($condition,array('inputtime'=>'desc'),$start,$limit);
		$productmore = new Productmore();
		foreach ($result as $k=>$v){
			$data[$k]['id']          = $v['id'];
			$data[$k]['title']       = $v['title'];
			if($index<4){
				$data[$k]['thumb_picture_url'] = $slide[$index];
				$data[$k]['is_slide'] = 1;
			}else{
				$data[$k]['is_slide'] = 0;
				$data[$k]['thumb_picture_url'] = ($v['thumb']) ?$v['thumb'] :null;
			}
			
			$data[$k]['description'] =$v['description'];
			$data[$k]['created_at']  = intval($v['inputtime']);
			$pinfo = $productmore->view(array('id'=> $v['id']));
			$data[$k]['html_content']  =  $this->tpl($data[$k]['title'] ,$data[$k]['created_at'],$pinfo['content'] );
			$index++;
		}
		return array(
		'is_end'=>$is_end,
		'data'=>$data
		);
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
				article .content p{text-indent:2em;margin:8px 0px}
				article .content img{width:260px;height:auto;display:block;margin:0px auto}
				</style>
				</head>
				<body>
				<article>
				<h1>'.$title.'</h1>
				<div class="date">
				<span>时间：'.date('Y-m-d H:i:s',$created_at).' </span>
				</div>
				<div class="content">'.$content.'</div>
				</article>
				</body>
				</html>';
	}
}
?>