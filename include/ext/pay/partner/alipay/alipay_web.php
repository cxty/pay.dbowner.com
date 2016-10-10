<?php
/**
 * alipay支付
 *
 * @author wbqing405@sina.com
 */
class alipay_web{
	
	public function __construct($config){
		$this->config = $config;
	}
	/**
	 * 
	 */
	private function include_alipay_submit(){
		require_once("web/alipay_submit.class.php");
	}
	/**
	 *
	 */
	private function include_alipay_notify(){
		require_once("web/alipay_notify.class.php");
	}
	/**
	 * 
	 */
	public function payment($fieldArr){
		$this->include_alipay_submit();
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service"           => "create_direct_pay_by_user",
			"partner"           => $this->config['alipay']['partner'],
			"payment_type"	    => $this->config['alipay']['payment_type'],
			"notify_url"	    => $this->config['notify_url'],
			"return_url"	    => $this->config['return_url'],
			"seller_email"	    => $this->config['alipay']['seller_email'],
			"out_trade_no"	    => $fieldArr['out_trade_no'],
			"subject"	        => $fieldArr['subject'],
			"total_fee"	        => $fieldArr['total_fee'],
			"body"	            => $fieldArr['body'],
			"show_url"	        => $this->config['show_url'],
			"anti_phishing_key"	=> $this->config['alipay']['anti_phishing_key'],
			"exter_invoke_ip"	=> $this->config['alipay']['exter_invoke_ip'],
			"_input_charset"	=> strtolower($this->config['alipay']['input_charset'])
		);
		
//ComFun::pr($parameter);exit;		
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config['alipay']);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "");
		
		echo $html_text;
		exit;	
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