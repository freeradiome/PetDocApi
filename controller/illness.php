<?php
/**
 * 疾病控制器
 *
 */
class Illness extends Controller{
	
	//列表显示疾病症状的个数
	private $_ill_tag_number = 200;

	/**
	 * 推导词下的疾病列表
	 *
	 */
	function tag_filter_list(){
		$tag = trim( _g('tag') );
		$uuid = trim( _g('uid') );
		if(!$tag){
			$this->get_params_error('tag不能为空!');
		}
		$tg_historys = new Tag_historys();
		$tg_historys->write($tag,$uuid);
		$tag = preg_replace('/[\s]+/',' ',$tag);

		$sql_part = '';
		$tag_arr=array();
		if( $tag){
			$tag_arr = explode(' ',$tag);
			foreach ($tag_arr as $val){
				$sql_part.= " knowledge_zz LIKE '%,{$val},%'  and";
			}

		}
		 
		$sql_part .= ' 1=1';
			$sql = "SELECT
	      knowledge_id as id,knowledge_title as title,knowledge_tags as other_name,knowledge_middlertype as master,knowledge_bigtype as normal  
	    FROM
	      knowledge 
	    WHERE $sql_part
	    order by knowledge_bigtype desc,knowledge_see_num desc";

			$ill = new Illnesses();
			
			$data = array();
			$data['is_page_end']=false;
			$data['lists']  = array();
			$data['lists'] = $ill->_db->getAll($sql);
			$tagrelationship = new Tagrelationship();
			foreach ($data['lists'] as $k=>$v){
				$data['lists'][$k]['master'] = Illnesses::$_master_type_list[$v['master']];
				$data['lists'][$k]['tags']= $tagrelationship->tag_lists($v['id'],$this->_ill_tag_number);
				$data['lists'][$k]['pic'] =  PUBLIC_ROOT.'kownpic/'.$v['id'].'.jpg';
			}
			$this->sucess($data);
			
			
		 
			
	}

	/**
	 * 获取疾病分类
	 *
	 */
	function type_list(){

		$iCat = new Illnesstypes();
		$list = $iCat->cat_list();
		$this->sucess($list);
	}

	/**
	 * 获取疾病列表
	 *
	 */
	function lists(){
		$id= _g('id');
		$start = intval( _g('start') );
		$start = ($start) ? $start :0;
		$limit =intval( _g('limit') );
		$limit = ($limit)?$limit:20;
		$word = trim( _g('word') );

		if( !intval($id)  && !$word ){
			$this->get_params_error('分类ID不能为空!');
		}
		$data = array();
		$ill = new Illnesses();
		$list = $ill->ill_list($id,$start,$limit,$word);
		
		$count = $ill->ill_count($id,$word);
		$data['word'] = $word;
		$data['is_page_end'] = ( $start+$limit<$count ) ? false :true;
		$tagrelationship = new Tagrelationship();
		
		
		
		$it=	new Illnesstypes();
		if( $id ){
			$info = $it->item('illness_illtype as  name')->view(array('illnesstype_id'=>$list['0']['catname']));
			 $data['cat_name']=$info['name'];
		}
		
		foreach ($list as  $k=>$v){
			
			
			$list[$k]['master']= Illnesses::$_master_type_list[$v['master']];
			$list[$k]['tags']= $tagrelationship->tag_lists($v['id'],$this->_ill_tag_number);
			$list[$k]['pic'] = PUBLIC_ROOT.'kownpic/'.$v['id'].'.jpg';
		}
		$data['lists'] = $list;
		$this->sucess($data);
	}

	/**
	 * 获取疾病详情
	 *
	 */
	function detail(){
		$id= _g('id');
		$uid =  _g('uid');
		if( !intval($id) ){
			$this->get_params_error('分类ID不能为空!');
		}
		$ill = new Illnesses();
		$info = $ill->ill_info($id);

		$tagrelationship = new Tagrelationship();
		$info['master']= Illnesses::$_master_type_list[$info['master']];
		$info['tags']= $tagrelationship->tag_lists($info['id']);
		if( $uid ){
			$fav = new Favs();
			$infod = $fav->item('id')->view(array('unqiue_device_id'=>$uid,'ill_id'=>$id));
			$info['is_fav'] = ($infod)?true:false;
		}
		$it=	new Illnesstypes();
		$itinfo = $it->item('illness_illtype as  name')->view(array('illnesstype_id'=>$info['catname']));
		$info['pic'] = PUBLIC_ROOT.'kownpic/'.$info['id'].'.jpg';
		$info['catname'] = $itinfo['name'];
		
		$this->sucess($info);
	}
}
