<?php 
class Citys extends Application{

	protected  $_tablename = 'v9_linkage'; //绑定数据库

	private $_s_city = array(
	'2'=> '北京市',
	'3'=> '上海市',
	'4'=> '天津市',
	'5'=> '重庆市',
	'34'=> '香港',
	'35'=> '澳门'
	
	);
	private $_city = array(

	'6'=> '河北省',
	'7'=> '山西省',
	'8'=> '内蒙古',
	'9'=> '辽宁省',
	'10'=> '吉林省',
	'11'=> '黑龙江省',
	'12'=> '江苏省',
	'13'=> '浙江省',
	'14'=> '安徽省',
	'15'=> '福建省',
	'16'=> '江西省',
	'17'=> '山东省',
	'18'=> '河南省',
	'19'=> '湖北省',
	'20'=> '湖南省',
	'21'=> '广东省',
	'22'=> '广西',
	'23'=> '海南省',
	'24'=> '四川省',
	'25'=> '贵州省',
	'26'=> '云南省',
	'27'=> '西藏',
	'28'=> '陕西省',
	'29'=> '甘肃省',
	'30'=> '青海省',
	'31'=> '宁夏',
	'32'=> '新疆',
	'33'=> '台湾省',
	'3358'=> '台湾省',

	);
	public function city_list($keyword=''){
		$ids  = implode(',',array_keys( $this->_city));
		$sids  = implode(',',array_keys( $this->_s_city));
		$sql_part = '';
		if( $keyword ){
			$sql_part = "  `name` like '$keyword%' and ";
		}
		$sql = "SELECT * FROM `v9_linkage` WHERE $sql_part  ( parentid IN ($ids) OR linkageid IN ($sids) )";
		$lists = 	$this->_db->getAll($sql);
		$array = array();
		foreach ($lists as $k=>$v){
			$array[$k]['id'] = (int)$v['linkageid'];
			$array[$k]['name'] = str_replace('市','',$v['name']);
//			echo $array[$k]['name'].'<br />';
		}
		return $array;
	}
	
	/**
	 * 是否为存在的城市
	 *
	 * @param string $city
	 * @return bool
	 */
	function is_exist_city($city){
		$result = $this->view(array(
			'name'=>$city
		));
		if(  $result ) return true;
	}
}
?>