<?php
/**
 * alipay支付
 *
 * @author wbqing405@sina.com
 */
class alipay{
	
	var $mobile = false; //默认web端
	
	public function __construct($config){
		$this->config = $config;
	}
	/**
	 * 包含文件
	 */
	private function include_alipay () {
		if ( $this->mobile === true ) {
			$className = 'alipay_wap';
		} else {
			$className = 'alipay_web';
		}
		$className = 'alipay_wap';
		require_once('alipay/' . $className . '.php');
		
		$this->pay = new $className ( $this->config ) ;
	}
	
	/**
	 * 付款
	 */
	public function payment($fieldArr){
		$this->include_alipay();
		$this->mobile = $fieldArr['mobile'] ? $fieldArr['mobile'] === true ? true : false : false;
		
		return $this->pay->payment($fieldArr);
	}
	/**
	 * 返回信息，确认信息的正确性
	 */
	public function execute($fieldArr){
		$this->include_alipay_notify();

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($this->config['alipay']);

		return $alipayNotify->verifyReturn($fieldArr);		
	}
	/**
	 * 退款
	 */
	public function refund(){
		
	}
	/**
	 * 提现
	 */
	public function withdraw($fieldArr){
		$this->include_alipay_submit();
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "batch_trans_notify",
				"partner" => $this->config['alipay']['partner'],
				"notify_url"	=> $this->config['notify_url'],
				"email"	=> $this->config['alipay']['seller_email'],
				"account_name"	=> $this->config['alipay']['account_name'],
				"pay_date"	=> date('Ymd'),
				"batch_no"	=> date('Ymd').time(),
				"batch_fee"	=> $fieldArr['batch_fee'],
				"batch_num"	=> $fieldArr['batch_num'],
				"detail_data"	=> $fieldArr['detail_data'],
				"_input_charset"	=> strtolower($this->config['alipay']['input_charset'])
		);
//ComFun::pr($parameter);exit;
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config['alipay']);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "");
		
		echo $html_text;
	}
}