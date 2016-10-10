<?php
/**
 * paypal支付
 * 
 * @author wbqing405@sina.com
 */
class paypal{
	
	public function __construct($config){
		$this->config = $config;
	}
	/**
	 * 初始化，并得到access_token
	 */
	public function init(){
		$url = $this->config['paypal']['host'].'/v1/oauth2/token';
		
		$encoded_data = 'grant_type=client_credentials';
		
		$config = array(
				'client_id' => $this->config['paypal']['client_id'],
				'secret' => $this->config['paypal']['secret']
		);
		
		$re = json_decode($this->curl($url, 'POST', $encoded_data, $config), true);
		
		$access_token = $re['access_token'];
		
		$cookies['pay_paypal_access_token'] = $access_token;
		ComFun::SetCookies($cookies);
		
		return $access_token;
	}
	/**
	 * 提交订单，返回订单信息，过滤出让用户确认的url
	 */
	public function payment($fieldArr){	
		$access_token = $this->init();
		
		$data = '{
			"intent":"' . $this->config['paypal']['intent'] . '",
			"redirect_urls":{
				"return_url":"' . $this->config['return_url'] . '",
				"cancel_url":"' . $this->config['cancel_url'] . '"
			},
			"payer":{
				"payment_method":"paypal"
			},
			"transactions":[
				{
					"amount":{
						"total":"' . $fieldArr['total'] . '",
						"currency":"USD"
					}
				}
			]
		}';

		$url = $this->config['paypal']['host'].'/v1/payments/payment';
		
		$config = array('access_token' => $access_token);
		
		$re = json_decode($this->curl($url, 'POST', $data, $config), true);
		
		if( isset($re['debug_id']) ){
			$rb['status']    = false;
		}else{
			$cookies['pay_paypal_payer_id'] = $re['id'];
			ComFun::SetCookies($cookies);
			
			$rb['status']    = true;
			$rb['url']       = $re['links'][1]['href'];
		}
		
		return $rb;
	}
	/**
	 * 确认购买
	 */
	public function execute($fieldArr){
		$pay_id = ComFun::getCookies('pay_paypal_payer_id');
		
		$url = $this->config['paypal']['host'].'/v1/payments/payment/'.$pay_id.'/execute';
		
		$encoded_data = '{ "payer_id" : "'.$fieldArr['payer_id'].'" }';
		
		$config = array('access_token' => ComFun::getCookies('pay_paypal_access_token'));
		
		$re = json_decode($this->curl($url, 'POST', $encoded_data, $config), true);
		
		//ComFun::pr($re);
		
		//$url = 'https://api.sandbox.paypal.com/v1/payments/sale/3DH03523119337427';
		//$url = 'https://api.sandbox.paypal.com/v1/payments/payment/PAY-9WS63613V4661713XKIBBJ6I';
		
		if( isset($re['debug_id']) ){
			$rb['status']    = false;
		}else{
			$rb['status']        = true;
			$rb['state']         = $re['state'];
			$rb['email']         = $re['payer']['payer_info']['email'];
			$rb['last_name']     = $re['payer']['payer_info']['last_name'];
			$rb['first_name']    = $re['payer']['payer_info']['first_name'];
			$rb['pay_id']        = $re['id'];
			$rb['payer_id']      = $re['payer']['payer_info']['payer_id'];
			$rb['id']            = $re['transactions'][0]['related_resources'][0]['sale']['id'];
		}
	
		return $rb;
	}
	/**
	 * 退款,退款金额必须小于交易金额
	 */
	public function refund($fieldArr){
		$url = $this->config['paypal']['host'].'/v1/payments/sale/'.$fieldArr['id'].'/refund';
		$data = '{
			"amount":{
				"total":"' . $fieldArr['total'] . '",
				"currency":"USD"
			}
		}';

		$config = array('access_token' => ComFun::getCookies('pay_paypal_access_token'));
		
		$re = json_decode($this->curl($url, 'POST', $data, $config), true);
		
		if( isset($re['debug_id']) ){
			$rb['status']    = false;
		}else{
			$rb['status']    = true;
			$rb['refund_id'] = $re['id'];
			$rb['state']     = $re['state'];
		}
		//ComFun::pr($re);
		
		return $rb;
	}
	/**
	 * 提现
	 */
	public function withdraw(){
		
	}
	/**
	 * curl方法
	 */
	public function curl($url, $method='GET', $encoded_data, $config){
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, 30);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ci, CURLOPT_HEADER, false);
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
	
		curl_setopt($ci, CURLOPT_URL, $url );

		if($config['client_id']){
			curl_setopt($ci, CURLOPT_USERPWD, $config['client_id'] . ':' . $config['secret']);
		}
		
		if( isset($config['access_token']) ){
			$headers[] = "Content-Type:application/json" ;
			$headers[] = "Authorization:Bearer " . $config['access_token'] ;
		}else{
			$headers[] = "Accept: application/json" ;
			$headers[] = "Accept-Language: en_US" ;
			$headers[] = 'content-type : application/x-www-form-urlencoded';
		}

		/*
		echo $url;
		ComFun::pr($headers);
		ComFun::pr($encoded_data);
		*/
		
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		
		if( strtolower($method) == 'post' ){
			curl_setopt($ci, CURLOPT_POST, TRUE);
			curl_setopt($ci, CURLOPT_POSTFIELDS, $encoded_data);
		}
	
		/*
		$http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$http_info = curl_getinfo($ci);
		echo '<pre>';
		print_r($http_info);
		echo '</pre>';
		*/
		
		$response = curl_exec($ci);	
		curl_close ($ci);

		return $response;
	}
}