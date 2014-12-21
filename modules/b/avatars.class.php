<?php 
class Avatars{

	private $_upload_path='uploadfile/';
	
	private $_file_size = 20971520;

	/**
	 * 获取用户头像
	 *
	 * @param int $uid
	 * @return string
	 */
	function get($uid){
		if( $this->is_saved($uid) ){
			return PUBLIC_ROOT.'phpsso_server/uploadfile/avatar/1/1/'.$uid.'/180x180.jpg';
		}else{
			return 'http://sh.868.sc/rest/public/images/140x140.png';
		}
	}
	
	 function emu_getallheaders() { 
        foreach ($_SERVER as $name => $value) 
       { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
               $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))); 
               $headers[$name] = $value; 
           } else if ($name == "CONTENT_TYPE") { 
               $headers["Content-Type"] = $value; 
           } else if ($name == "CONTENT_LENGTH") { 
               $headers["Content-Length"] = $value; 
           } 
       } 
       return $headers; 
    } 


	/**
	 * 上传图片并返回路径
	 *
	 * @param string $file 控件信息
	 * @return string
	 */
	public  function upload_thumb($file,$uid){
		
		$image = new Image();
		$image->input_name=$file;
		$image->file_size=$this->_file_size;
       		 $image->save_path = SH_PATH.'phpsso_server/uploadfile/avatar/1/1/'.$uid.'/';
	 
	        if(!file_exists(  $image->save_path)){ 
	        	@mkdir(  $image->save_path,0777);
	        }
		$image->to_w=180;
		$image->savefile_name = '180x180.jpg';
		$result =  $image->ImageResize() ;
		if( $result ==2 || $result ==3){
			return false ;
		}
	
		$image->to_w=90;
		$image->savefile_name = '90x90.jpg';
		$result =  $image->ImageResize() ;


		$image->to_w=45;
		$image->savefile_name = '45x45.jpg';
		$result =  $image->ImageResize() ;

		$image->to_w=30;
		$image->savefile_name = '30x30.jpg';
		$result =  $image->ImageResize() ;
		$phpsso = new  phpsso();
		$info = $phpsso->update(array('uid'=>$uid),array('avatar'=>1),false);
		return PUBLIC_ROOT.'phpsso_server/uploadfile/avatar/1/1/'.$uid.'/180x180.jpg';
	}

	/**
	 * 是否上传图像
	 *
	 * @param int $uid
	 * @return array
	 */
	private function  is_saved($uid){
		$phpsso = new  phpsso();
		$info = $phpsso->view(array('uid'=>$uid));
		if($info['avatar']==1){
			return true;
		}
	}

}
?>