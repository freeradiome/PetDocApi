<?php
/**
 * 批量任务脚本
 * zengweiqi
 * 2013-06-21
 *
 */
class Bat extends Controller {


	private $_list_limit =101;

	function combat(){
		set_time_limit(0);
		ob_end_clean();
		$IL = new Illnesses()	;
		$LS = $IL->lists(array(),array(),0,100000);
		foreach ($LS as $v){
			if($v['knowledge_zz']){
				$sql ="update knowledge set knowledge_zz = '".','.$v['knowledge_zz'].','."' where knowledge_id={$v['knowledge_id']}";

				$IL->_db->execute($sql);
				echo $v['knowledge_id']."\r\n";
			}
		}
	}

	function type(){
		set_time_limit(0);
		ob_end_clean();
		$tags = new Tagrelationship();
		$list = $tags->lists(array('tagall_thetype'=>"{ is   null }"),array(),0,10000);

		$tagtype = new Tags();

		foreach ($list as $v){
			$info = $tagtype->view(array('name'=>$v['tagall_name']));

			$tags->update(array('tagall_id'=>$v['tagall_id']),array(
			'tagall_thetype'=>$info['tagall_thetype']
			),false,false);
			echo $v['tagall_id']."\r\n";

		}

	}
	function tags(){


		set_time_limit(0);
		ob_end_clean();
		$ill = new Illnesses();
		$lists = $ill->lists(array(),array(),0,600);
		$tag = new Tagrelationship();

		foreach ($lists  as $v){
			echo $v['knowledge_id'].$v['knowledge_title'].'<br />';
			$z = $tag->tag_lists($v['knowledge_id']);
			$sa =  array();
			foreach ($z as $d){
				array_push($sa,$d['tagall_name']);
			}
			$sa = implode(',',$sa);
			$ill->update(array('knowledge_id'=>$v['knowledge_id']),array('knowledge_zz'=>$sa),false,false);

		}


	}

	function py2(){
		$py = new Py('utf-8');
		$result = $py->getInitials('鞑');
		echo $result;
	}


	function testbug(){

		$goods = new Goods();

		$access =new Access();

		$goods->lists(array(),array(),0,1);

		$access->lists(array(),array(),0,1);
		die();
		$goods->lists(array(),array(),0,1);
		print_r($access->_db_config);
		echo '<hr />';

	}
	/**
	 * 猜想词记录数批量脚本
	 *
	 */
	function word_record_count(){
		set_time_limit(0);
		ob_end_clean();
		$Suggestions = new Suggestions();
		$count = $Suggestions->count(array());
		$paged = new Page($count,$this->_list_limit);
		$suggestions = new Suggestions();
		$goods = new Goods();
		$nu = 0;
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $Suggestions->item('id,word')->lists(array(),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){
				$word=  trim($v['word']);
				$count = $goods->count(array('title'=>"{ like '%$word%' }"));
				echo $goods->_last_sql."\r\n";
				$Suggestions->update(array('id'=>$v['id']),array('count'=>$count),false,false) ;
				echo $Suggestions->_last_sql."\r\n";
				$nu++;

			}


		}
		echo $nu."\r\n";
		echo 'end';
	}

	/**
	 * 打标产品的关键字
	 *
	 */
	function scws(){
		set_time_limit(0);
		ob_end_clean();
		$goods = new Goods();
		$count = $goods->count(array());
		$paged = new Page($count,$this->_list_limit);
		$suggestions = new Suggestions();
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $goods->item('id,title')->lists(array(),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){
				$title =  trim($v['title']);
				$scws_array = scws_split_word($title);
				foreach ($scws_array as $v){
					$suggestions->touch_word($v,0);
					echo $suggestions->_last_sql."\r\n";
				}
			}


		}
		echo 'end';
	}

	function py(){
		set_time_limit(0);
		ob_end_clean();
		$goods = new Goods();
		$count = $goods->count(array());
		$paged = new Page($count,$this->_list_limit);
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $goods->item('id,title')->lists(array(),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){
				$title =  trim($v['title']);
				$goods->update(array('id'=>$v['id']),array(
				'title'=>$v['title'],
				'py'=>''
				));
				echo $goods->_last_sql ."\r\n";
			}


		}
		echo 'end';
	}
	function user_flat(){
		set_time_limit(0);
		ob_end_clean();
		$access = new Access();
		$count = $access->count();
		$paged = new Page($count,$this->_list_limit);
		$ti =0;
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $access->items(array('id','device_unique_key','created_at'))->lists(array(),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){

				$today = date('Y-m-d',strtotime($v['created_at']));
				$is_new_user = $access->view(array('device_unique_key'=>$v['device_unique_key'],'created_at'=>"{ <'$today' }"));
				$flag = (!$is_new_user)?1:0;
				echo $v['created_at'].'-'.$access->_last_sql;
				$access->update(array('id'=>$v['id']),array(
				'flag'=>$flag
				));
				$ti++;
				echo $v['id'].'-'.$flag.'-'.$ti."\r\n";
			}
		}

	}

	/**
	 * 批量打标找出重复的数据
	 *
	 */
	function x(){
		set_time_limit(0);
		ob_end_clean();
		$goods = new Goods();
		$count = $goods->count(array('qc'=>"{ is null }"));
		$paged = new Page($count,$this->_list_limit);
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $goods->lists(array('qc'=>"{ is null }"),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){
				$goods->update(array('id'=>$v['id']),array(
				'qc'=>md5(   $v['url'].$v['shop_name'].$v['sale_price'].$v['shop_addres'].$v['shop_phone']    )
				),false);
				echo $goods->_last_sql ."\r\n";

			}


		}
		echo 'end';

	}

	/**
	 * 批量处理团购图片
	 *
	 */
	function goods_img(){

		set_time_limit(0);
		ob_end_clean();
		$goods = new Goods();
		$count = $goods->count();
		$paged = new Page($count,$this->_list_limit);
		for ($i=1;$i<=$paged->pagecount;$i++){
			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			$result = $goods->items(array('id'))->lists(array('goods_end_at'=>"{ >'2013-12-18' }"),array(),$page->start,$page->limit);
			foreach ( $result as $k=>$v){
				$goods->update(array('id'=>$v['id']),array('lo_pic'=>'tmpimg/'.($v['id']%200).'/'.$v['id'].'.jpg' ),false);
				echo $goods->_last_sql."\r\n";

			}

		}
		echo 1;
	}

	function tile(){
		set_time_limit(0);
		ob_end_clean();
		$metro = new metro();
		$list = $metro->lists(array(),array('pc_sort'=>'asc'),0,1000);
		$metro = new Metropc();
		foreach ($list as $k=>$v){
			$data=$v;
			unset($data['id']);

			$metro->add($data,false,false);
			echo $metro->_last_sql."\r\n";

		}
	}

	function tilem(){
		set_time_limit(0);
		ob_end_clean();
		$metro = new metro();
		$list = $metro->lists(array(),array('sort'=>'asc'),0,1000);
		$sql = "DELETE FROM metro";
		$metro->_db->execute($sql);

		//		$metro = new Metropc();
		foreach ($list as $k=>$v){
			$data=$v;
			unset($data['id']);

			$metro->add($data,false,false);
			echo $metro->_last_sql."\r\n";

		}
	}

	function url_get_contents($url) {
		$cnt=0;
		while($cnt < 3 && ($html=file_get_contents($url) )===FALSE) $cnt++;
		if($html){
			return  $html;
		}

	}


	function user_flat2(){
		set_time_limit(0);
		ob_end_clean();
		$goods = new Goods();
		$count = $goods->count();
		$paged = new Page($count,$this->_list_limit);
		$base=ROOT_PATH.'tmpimg/';
		if ( !file_exists( $base) ){
			mkdir( $base,0777);
		}

		for ($i=1;$i<=$paged->pagecount;$i++){

			$_GET['page'] = $i;
			$page = new Page($count,$this->_list_limit);
			//			$result = $goods->items(array('id','bigimg_url'))->lists(array('goods_end_at'=>"{ >'2013-12-18' }",'lo_pic'=>"{ is  null }"),array(),$page->start,$page->limit);
			$result = $goods->items(array('id','bigimg_url','lo_pic'))->lists(array('goods_end_at'=>"{ >'2013-12-18' }"),array(),$page->start,$page->limit);

			foreach ( $result as $k=>$v){
				if(!$v['lo_pic']){
					$cfile = $v['id']%200;
					if ( !file_exists( $base.$cfile) ){
						mkdir( $base.$cfile,0777);
					}
					$f_name =($v['id'].'.jpg');
					echo $base.$cfile.'/'.$f_name;
					$size_count = file_put_contents($base.$cfile.'/'.$f_name ,$this->url_get_contents($v['bigimg_url']));
					if( $size_count ){
						$goods->update(array('id'=>$v['id']),array(
						'lo_pic'=>'tmpimg/'.$cfile.'/'.$f_name
						));
						echo $v['id']."\r\n";
					}
				}

			}
		}

	}

}
