<?php
/**
 * OAuth 2.0 Class
 *
 */
include_once('ComFun.class.php'); //公共方法
class OAuth {
	/**
	 * @ignore
	 */
	public $client_id;
	/**
	 * @ignore
	 */
	public $client_secret;
	/**
	 * @ignore
	 */
	public $access_token;
	/**
	 * @ignore
	 */
	public $refresh_token;
	/**
	 * Contains the last HTTP status code returned.
	 *
	 * @ignore
	 */
	public $http_code;
	/**
	 * Contains the last API call.
	 *
	 * @ignore
	 */
	public $url;
	/**
	 * Set timeout default.
	 *
	 * @ignore
	 */
	public $timeout = 30;
	/**
	 * Set connect timeout.
	 *
	 * @ignore
	 */
	public $connecttimeout = 30;
	/**
	 * Verify SSL Cert.
	 *
	 * @ignore
	 */
	public $ssl_verifypeer = FALSE;
	/**
	 * Respons format.
	 *
	 * @ignore
	 */
	public $format = 'json';
	/**
	 * Decode returned json data.
	 *
	 * @ignore
	 */
	public $decode_json = TRUE;
	/**
	 * Contains the last HTTP headers returned.
	 *
	 * @ignore
	 */
	public $http_info;
	/**
	 * Set the useragnet.
	 *
	 * @ignore
	 */
	//public $useragent = 'Sae T OAuth2 v0.1';

	/**
	 * print the debug info
	 *
	 * @ignore
	 */
	public $debug = FALSE;

	/**
	 * boundary of multipart
	 * @ignore
	 */
	public static $boundary = '';
	
	/**
	 * construct partnerOAuth object
	 */
	function __construct($host,$client_id, $client_secret, $access_token = NULL, $refresh_token = NULL) {
		$this->host = $host;
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->access_token = $access_token;
		$this->refresh_token = $refresh_token;
	}
	/**
	 * GET wrappwer for oAuthRequest.
	 *
	 * @return mixed
	 */
	function get($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'GET', $parameters);

		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * POST wreapper for oAuthRequest.
	 *
	 * @return mixed
	 */
	function post($url, $parameters = array(), $multi = false) {
		//echo $url;ComFun::pr($parameters);exit;
		$response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
		if ($this->format === 'json' && $this->decode_json) {
			//ComFun::pr($response);exit;
			return json_decode($response, true);
		}
		return $response;
	}
	/**
	 * Format and sign an OAuth / API request
	 *
	 * @return string
	 * @ignore
	 */
	function oAuthRequest($url, $method, $parameters, $multi = false) {

		if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
			$url = "{$this->host}{$url}.{$this->format}";
		}

		switch ($method) {
			case 'GET':
				$url = $url . '?' . http_build_query($parameters);
				
				return $this->http($url, 'GET');
			default:
				$headers = array();
				if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
					$body = http_build_query($parameters);
				} else {
					$body = self::build_http_query_multi($parameters);
					$headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
				}
				return $this->http($url, $method, $body, $headers);
		}
	}

	/**
	 * Make an HTTP request
	 *
	 * @return string API results
	 * @ignore
	 */
	function http($url, $method, $postfields = NULL, $headers = array()) {
		$this->http_info = array();
		$ci = curl_init();
		/* Curl settings */
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		//curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
		//curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);

		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
					$this->postdata = $postfields;
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}

		if ( isset($this->access_token) && $this->access_token )
			$headers[] = "Authorization: OAuth2 ".$this->access_token;

		$headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

		$response = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;

// 		var_dump($response);
// 		if ($this->debug) {
// 			echo "=====post data======\r\n";
// 			var_dump($postfields);

// 			echo '=====info====='."\r\n";
// 			print_r( curl_getinfo($ci) );

// 			echo '=====$response====='."\r\n";
// 			print_r( $response );
// 		}
		curl_close ($ci);
		return $response;
	}	
	/**
	 * 取加密的$_COOKIE值
	 */
	public function getCookies($value=false){
		echo $value;exit;
		echo dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/include/lib/ComFun.class.php';exit;
		include_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/include/lib/ComFun.class.php');
		return ComFun::getCookies($value);
	}
	
	function pr($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
}