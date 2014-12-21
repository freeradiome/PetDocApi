<?php
/**
 * 疾病症状
 *
 */
class Tags extends  Application{
	
	protected  $_tablename = 'tagall_index'; //绑定数据库
	

	/**
	 * 获取疾病症状表
	 *
	 * @return unknown
	 */
	function tlist($id){
//		$sql = "
//SELECT tagall_id AS id,tagall_name AS NAME,tagall_thetype,COUNT(*) AS COUNT FROM tagall WHERE tagall_type=0 
//		  GROUP BY NAME 
//		  ORDER BY COUNT DESC";
//		$sql = "select tagall_id as id,tagall_name as name,count(*) as count from tagall where tagall_thetype=".$id." and tagall_type=0 
//		  group by name 
//		  order by count desc";
		$list = $this->item('id,name')->lists(array('tagall_thetype'=>$id),array('count'=>'desc'),0,1000);
		return $list;
	}
	/**
	 * 获取所有症状词
	 *
	 */
	function all_list(){
//		$sql="SELECT 
//			 tagall_id,tagall_name,tagall_ill,tagall_thetype, COUNT(tagall_name) AS COUNT
//			FROM
//			  tagall 
//			GROUP BY tagall_name
//			ORDER BY COUNT DESC";
		$list = $this->item('id,name')->lists(array(),array('count'=>'desc'),0,1000);
		return $list;
		
	}
	
	
	
	
}

?>