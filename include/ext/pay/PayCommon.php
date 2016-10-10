<?php
/**
 * 支付统一接口
 * 
 * @author wbqing405@sina.com
 */
class PayCommon{
	
	public function __construct(){
		
	}
	/**
	 * 初始化支付类
	 */
	private function init(){	
		$paytype = strtolower($GLOBALS['config']['pay']['paytype']);
		
		$file = dirname(__FILE__).'/partner/'.$paytype.'.php';
		
		if( file_exists($file) ){
			include($file);
			$this->pay = new $paytype($GLOBALS['config']['pay']);
		}else{
			return false;	
		}
	}
	/**
	 * 提交订单，返回让用户确认购买信息
	 */
	public function payment($fieldArr){
		$this->init();
		
		return $this->pay->payment($fieldArr);	
	}
	/**
	 * 购买确认
	 */
	public function execute($fieldArr){
		$this->init();
		
		return $this->pay->execute($fieldArr);
	}
	/**
	 * 返款
	 */
	public function refund($fieldArr){
		$this->init();

		return $this->pay->refund($fieldArr);
	}
	/**
	 * 提现
	 */
	public function withdraw($fieldArr){
		$this->init();
		
		return $this->pay->withdraw($fieldArr);
	}
}