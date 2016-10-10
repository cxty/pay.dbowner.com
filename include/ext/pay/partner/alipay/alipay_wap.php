<?php
/**
 * alipay支付
 *
 * @author wbqing405@sina.com
 */
class alipay_wap{
	
	public function __construct($config){
		$this->config = $config;
	}
	/**
	 * 
	 */
	private function include_alipay_submit(){
		require_once("wap/alipay_submit.class.php");
	}
	/**
	 *
	 */
	private function include_alipay_notify(){
		require_once("wap/alipay_notify.class.php");
	}
	/**
	 * 
	 */
	public function payment($fieldArr){
		$this->include_alipay_submit();
	
		//请求号
		$req_id = date('Ymdhis');
		//必填，须保证每次请求都是唯一
		
		//请求业务参数详细
		$req_data = '<direct_trade_create_req>
						<notify_url>' . $this->config['mo_notify_url'] . '</notify_url>
						<call_back_url>' . $this->config['mo_return_url'] . '</call_back_url>
						<seller_account_name>' . $this->config['alipay']['seller_email'] . '</seller_account_name>
						<out_trade_no>' . $fieldArr['out_trade_no'] . '</out_trade_no>
						<subject>' . $fieldArr['subject'] . '</subject>
						<total_fee>' . $fieldArr['total_fee'] . '</total_fee>
						<merchant_url>' . $this->config['mo_merchant_url'] . '</merchant_url>
					</direct_trade_create_req>';

		$para_token = array(
				"service"           => "alipay.wap.trade.create.direct",
				"partner"           => $this->config['alipay']['partner'],
				"sec_id"            => trim($this->config['alipay']['sign_type']),
				"format"	        => $this->config['alipay']['wrap_format'],
				"v"	                => $this->config['alipay']['wrap_v'],
				"req_id"	        => $req_id,
				"req_data"	        => $req_data,
				"_input_charset"	=> trim(strtolower($this->config['alipay']['input_charset']))
		);
	
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config['alipay']);
		$html_text = $alipaySubmit->buildRequestHttp($para_token);
		
		//URLDECODE返回的信息
		$html_text = urldecode($html_text);
		
		//解析远程模拟提交后返回的信息
		$para_html_text = $alipaySubmit->parseResponse($html_text);
		
		//获取request_token
		$request_token = $para_html_text['request_token'];
		
		
		/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/
		
		//业务详细
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
		//必填
		
		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service"           => "alipay.wap.auth.authAndExecute",
				"partner"           => trim($this->config['alipay']['partner']['partner']),
				"sec_id"            => trim($this->config['alipay']['sign_type']),
				"format"	        => $this->config['alipay']['wrap_format'],
				"v"	                => $this->config['alipay']['wrap_v'],
				"req_id"	        => $req_id,
				"req_data"	        => $req_data,
				"_input_charset"	=> trim(strtolower($this->config['alipay']['input_charset']))
		);
		
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config['alipay']['alipay']);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
		echo $html_text;
		exit;
//ComFun::pr($parameter);exit;		
		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config['alipay']['alipay']);
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