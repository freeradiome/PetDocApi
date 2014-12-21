<?php 
/**
 * 企业会员注册
 *
 */ 
class Companys extends Application{

	protected  $_tablename = 'v9_yp_company'; //绑定数据库

	public $_validate = array(
	'url'=>array('xss'=>false),
	'menu'=>array('xss'=>false)
	);

	static public $_province = array(
	'北京',
	'上海',
	'杭州',
	'广州',
	'深圳',
	'南京',
	'武汉',
	'天津',
	'成都',
	'哈尔滨',
	'重庆',
	'宁波',
	'无锡',
	'济南',
	'苏州',
	'温州',
	'青岛',
	'沈阳',
	'福州',
	'西安',
	'长沙',
	'合肥',
	'南宁',
	'南昌',
	'郑州',
	'厦门',
	'大连',
	'常州',
	'石家庄',
	'东莞',
	'安徽',
	'福建',
	'甘肃',
	'广东',
	'广西',
	'贵州',
	'海南',
	'河北',
	'黑龙江',
	'河南',
	'湖北',
	'湖南',
	'江苏',
	'江西',
	'吉林',
	'辽宁',
	'内蒙古',
	'宁夏',
	'青海',
	'山东',
	'山西',
	'陕西',
	'四川',
	'新疆',
	'西藏',
	'云南',
	'浙江',
	'澳门',
	'台湾',
	'香港',
	'惠州',
	'佛山',
	'珠海',
	'中山',
	'海外',
	'其它'
	);

	//默认注册状态 0为未审核 1为审核通过
	private $_register_status = 1;

	//工商联职务
	static public $_shzw = array(
	1=>'普通会员',
	7=>'工商联副主席',
	6=>'工商联常委',
	5=>'工商联执委',
	4=>'商会副会长',
	3=>'商会常委',
	2=>'商会执委'
	);

	//注册类型
	static public $_reg_type = array(
	1=>'未经工商注册，个人',
	2=>'企业单位'
	);

	/**
	 * 推荐商家
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
		$result = $this->items('userid,companyname,introduce,logo,regtime')->lists($condition,array('regtime'=>'desc'),$start,$limit);
		foreach ($result as $k=>$v){
			$data[$k]['id']          = $v['userid'];
			$data[$k]['title']       = $v['companyname'];
			if($index<4){
				$data[$k]['thumb_picture_url'] = $slide[$index];
				$data[$k]['is_slide'] = 1;
			}else{
				$data[$k]['is_slide'] = 0;
				$data[$k]['thumb_picture_url'] = ($v['logo']) ?$v['logo'] : null;
			}
			$data[$k]['description'] = mb_substr($v['introduce'],0,99,'utf-8');
			$data[$k]['created_at']  = intval($v['regtime']);
			$data[$k]['html_content']  =  $this->tpl($data[$k]['title'] ,$data[$k]['created_at'],$v['introduce'] );
			$index++;
		}
		return array(
		'is_end'=>$is_end,
		'data'=>$data
		);
	}

	public function get_info($userid){
		return $this->view(array('userid'=>$userid));
	}

	/**
	 * 注册为企业会员
	 *
	 */
	public function register($uid,$shzw,$cname,$mobile,$idno,$rtype){
		$genre = ( $rtype==2 ) ?Companys::$_reg_type[2]:Companys::$_reg_type[1];
		$data = array(
		'companyname'=>$cname, //企业名称
		'catids'=>',商业服务,', //所属分类
		'pattern'=>',生产型,',//企业类型
		'products'=>'',//主营产品或服务
		'qq'=>'',//主营产品或服务
		'web_url'=>'',//主营产品或服务
		'genre'=>$genre,//未经工商注册，个人
		'areaname'=>'',//所在地区
		'address'=>'',//详细地址
		'status'=>$this->_register_status,//默认注册状态
		'regtime'=>time(),//注册时间
		'userid'=>$uid,//用户ID
		'tplname'=>'com_default',//默认名
		'idno'=>$idno,//状态
		'menu'=>$this->build_menu($uid),//状态
		'shzw'=>Companys::$_shzw[$shzw],//工商联职务
		'mobile'=>$mobile,//新加手机号码
		'url'=>PUBLIC_ROOT.'index.php?m=yp&c=com_index&userid='.$uid
		);
		if( $this->add($data,false,false) ){
			return  $data;
		}
		//Array ( [companyname] => 1 [catids] => , [pattern] => [qq] => 1 [web_url] => 1 [products] => 1 [genre] => 未经工商注册，个人 [areaname] => 北京 [address] => 1 [status] => 0 [regtime] => 1373790861 [userid] => 35 )
	}

	/**
	 * 是否为审核商家
	 *
	 * @param int $uid 是否为审核用户
	 * @return array
	 */
	public function is_checked($uid){
		if(  $this->items('userid')->view(array('userid'=>$uid,'status'=>'1')) ){
			return true;
		}
	}

	/**
	 * 建立列表字段
	 *
	 * @param int $uid
	 * @return string
	 */
	private function build_menu($uid){
		return "array (
		  'list' => 
		  array (
		    1 => '1',
		    2 => '2',
		    3 => '3',
		    4 => '4',
		    5 => '5',
		  ),
		  'catname' => 
		  array (
		    1 => 
		    array (
		      'used' => '1',
		      'id' => 'index',
		      'is_system' => '1',
		      'catname' => '首页',
		      'linkurl' =>'".PUBLIC_ROOT."index.php?m=yp&c=com_index&userid=$uid',
		    ),
		    2 => 
		    array (
		      'used' => '1',
		      'id' => 'about',
		      'is_system' => '1',
		      'catname' => '公司简介',
		      'linkurl' => '".PUBLIC_ROOT."index.php?m=yp&c=com_index&a=about&userid=$uid',
		    ),
		    3 => 
		    array (
		      'used' => '1',
		      'id' => 'certificate',
		      'is_system' => '1',
		      'catname' => '资质证书',
		      'linkurl' => '".PUBLIC_ROOT."index.php?m=yp&c=com_index&a=certificate&userid=$uid',
		    ),
		    4 => 
		    array (
		      'used' => '1',
		      'id' => 'guestbook',
		      'is_system' => '1',
		      'catname' => '在线留言',
		      'linkurl' =>  '".PUBLIC_ROOT."index.php?m=yp&c=com_index&a=guestbook&userid=$uid',
		    ),
		    5 => 
		    array (
		      'used' => '1',
		      'id' => 'contact',
		      'is_system' => '1',
		      'catname' => '联系我们',
		      'linkurl' => '".PUBLIC_ROOT."index.php?m=yp&c=com_index&a=contact&userid=$uid',
		    ),
		  ),
		)";

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
				<div class="content">'.strip_rss_tags($content).'</div>
				</article>
				</body>
				</html>';
	}

}
?>