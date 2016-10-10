<?php 
/**
 * soap调用接口
 * @author wbqing405@sina.com
 *
 */
class soapMod {	
	/**
	 * 调用扩展接口
	 */
	public function paySoap(){	
		include_once(dirname(dirname(__FILE__)).'/include/api/DBOwnerPay.php');
		ini_set("soap.wsdl_cache_enabled", "0");
		$server=new SoapServer(dirname(dirname(__FILE__)).'/Interface/DBOwnerPay.wsdl',
						array('soap_version' => SOAP_1_2,'encoding'=>'utf-8'));
		$server->setClass('DBOwnerPay');
		$server->handle();
	}
}
?>