<?php
/**
 *
 * 错误处理
 *
 * @author wbqing405@sina.com
 *
 */
class throwMessageMod extends commonMod{
	/**
	 * 错误提示
	 */
	public function throwMsg(){	
		$msgkey = $_GET[0] ? ComFun::__decrypt($_GET[0]) : 'Ex_UnknowError';
		$tt     = $_GET[1] ? ComFun::__decrypt($_GET[1]) : '1'; //是否跳转 1默认 2不跳转

		$msgArr['appshow'] = false;
		if($tt == 2){
			$msgArr['urlTurn'] = '';
		}else{
			$msgArr['urlTurn'] = $_GET[2] ? ComFun::__decrypt($_GET[2]) : '/';
		}	
		
		$msgArr['url']     = '/';
		$msgArr['retry']   = $_SERVER['REQUEST_URI'];
		$msgArr['msg']     = Lang::get(trim($msgkey));

		$this->assign('msgArr',$msgArr);
		$this->display('throwMessage/message.html');
	}
	/**
	 * 调用框架错误提示
	 */
	public function throwError(){
		$msgkey = $_GET[0] ? ComFun::__decrypt($_GET[0]) : 'Ex_UnknowError';
		
		echo '<div style="text-align:center;margin-top:20px;">'.Lang::get($msgkey).'</div>';
		exit;
	}
}