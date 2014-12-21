<?php
/**
 * 症状分类
 *
 */
class Tag extends Controller{

	/**
	 * 热门症状
	 *
	 */
	function hot(){
		$limit = intval(_g('limit'));
		$limit = ( $limit )?$limit:9;
		$sql = "SELECT 
  tagall.tagall_id AS id,
  tagall.tagall_name AS `name`,
	COUNT(tagall.tagall_id) AS number 
FROM
  tagall 
  INNER JOIN
  (SELECT 
    knowledge_id 
  FROM
    knowledge ) AS more 
  ON tagall.tagall_ill = more.knowledge_id 
WHERE 
   tagall_type = 0 
GROUP BY tagall.tagall_name 
ORDER BY number DESC limit $limit";
		$tags = new Tags();
		$result =$tags->_db->getAll($sql);
			$this->sucess($result);
	}
	/**
	 * 读取分类
	 *
	 */
	public function filter_tags_type(){
	
		$tag = trim( _g('tag') );
		$tag = preg_replace('/[\s]+/',' ',$tag);

		//		$tag = '发烧/体温上升 脱水';
		//		if(!$tag){
		//			$this->get_params_error('tag不能为空!');
		//		}
		//
		$tags = new Tags();
		//首次推算
		//组装SQL
		$sql_part = '';
		$except_sql = ' where';
		$tag_arr=array();
		if( $tag){
			$tag_arr = explode(' ',$tag);
			foreach ($tag_arr as $val){
				$sql_part.= " knowledge_zz LIKE '%,{$val},%'  and";
				$except_sql .= " tagall_name<>'$val'  AND ";
			}
			 
		}
		$sql_part .= ' 1=1';
		$except_sql .= " 1=1";
		//获取关键词的疾病
		$sql = "SELECT tagstype_id AS id,tagstype_name AS `name` FROM tagstype 
INNER JOIN(
 SELECT tagall_thetype FROM (SELECT    tagall.tagall_thetype,
 tagall.tagall_name FROM tagall
INNER JOIN (
SELECT knowledge_id FROM knowledge 
				WHERE $sql_part
) AS more
ON tagall.tagall_ill =  more.knowledge_id

GROUP BY tagall.tagall_name
ORDER BY COUNT(tagall.tagall_id) DESC ) as ccc
$except_sql
group by tagall_thetype ) AS lo 
ON lo.tagall_thetype = tagstype.tagstype_id
ORDER BY tagstype_desc ASC ";
	 	
		$list =$tags->_db->getAll($sql);
	 
		$this->sucess($list);
	}

	/**
	 * 获取筛选后栏目分类
	 *
	 */
	public function filter_tags(){
		$cat_id =intval( _g('cid')) ;
		$tag =  trim( _g('tag') );
		$tag = preg_replace('/[\s]+/',' ',$tag);
		if(!$cat_id){
			$this->get_params_error('catid不能为空!');
		}
		//		$cat_id = 17;
		//		$tag = '发烧/体温上升 脱水';



		$tags = new Tags();
		//首次推算
		//组装SQL
		$sql_part = '';
		$except_sql = '';
		$tag_arr=array();
		if( $tag){
			$tag_arr = explode(' ',$tag);
			foreach ($tag_arr as $val){
				$sql_part.= " knowledge_zz LIKE '%,{$val},%'  and";
				$except_sql .= " and tagall.tagall_name<>'$val'";
			}
			
		}
		
	
				$sql_part .= ' 1=1';
		//获取关键词的疾病
		$sql = "SELECT tagall.tagall_id as id,tagall.tagall_name as name FROM tagall
INNER JOIN (
SELECT knowledge_id FROM knowledge 
				WHERE $sql_part
) AS more
ON tagall.tagall_ill =  more.knowledge_id
WHERE tagall_thetype=$cat_id
		and tagall_type=0 $except_sql
GROUP BY tagall.tagall_name
ORDER BY COUNT(tagall.tagall_id) DESC";
		
		$tagtype = new Tagstypes();
		$tif = $tagtype->item('tagstype_name')->view(array('tagstype_id'=>$cat_id));
		$data = array();
		$data['id'] = $cat_id;
		$data['type_name'] = $tif['tagstype_name'];
		$data['list'] =$tags->_db->getAll($sql);
		
		$this->sucess($data);

	}
	/**
	 * 疾病症状分类
	 *
	 */
	public function tags_cat_list(){

		$TagsTypes = new Tagstypes();
		$lists = $TagsTypes->cat_list();
		 
		$this->sucess($lists);
	}


	/**
	 * 疾病症状列表
	 *
	 */
	public function tags_list(){
		$id = intval( _g('id')); //疾病分类

		if(!$id){
			$this->get_params_error('分类ID不能为空!');
		}
		$data = array();

		$TagsTypes = new Tagstypes();
		$type_info = $TagsTypes->item(array('tagstype_name as name'))->view(array('tagstype_id'=>$id));
		if( $type_info ){
			$tags = new Tags();
			$lists = $tags->tlist($id);
			$data['id']=$id;
			$data['type_name'] = $type_info['name'];
			$data['list'] = $lists;
			$this->sucess($data);
		}else {
			$this->get_params_error('分类ID不能为空!');
		}

	}



}
?>