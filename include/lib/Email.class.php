<?php 
/**
 * 邮件发送类
 * 
 * @author wbqing405@sina.com
 */

include_once('Config.class.php'); //引入处理类的编码格式 utf-8
include_once('ComFun.class.php'); //公共方法

class Email{
	
	public function __construct(){	
		$this->contentUrl = dirname(dirname(dirname(__FILE__)));
		
		include_once($this->contentUrl.'/include/lib/Lang.class.php');
		$this->EmailLang = Lang::get('EmailLang');

		global $config;

		$this->url            = $config['EMAIL']['url'];
		$this->UserName       = $config['EMAIL']['UserName'];
		$this->UserPWD        = $config['EMAIL']['UserPWD'];	
		$this->mSender        = $this->EmailLang['EmSender'];
		$this->mSendMail      = $config['EMAIL']['mSendMail'];
		$this->mIsHTML        = $config['EMAIL']['mIsHTML'];
		$this->SetSendTime    = $config['EMAIL']['SetSendTime'];	

		$this->iurl           = $config['PLATFORM']['Auth'];
	}
	/**
	 * 取用户信息
	 */
	private function getReceiverName(){
		$userInfo = ComFun::getThirdInfoByGet('/db/getUserInfo',ComFun::getTConditionByCurl($this->provider));
		
		$this->Receiver = $userInfo['uDisplay_name'];
	}
	/**
	 * 选择发送邮件的格式
	 * 
	 * @param unknown_type $fieldArr 发送邮件所需信息
	 * @param unknown_type $type 发送邮件类型  
	 */
	public function sendMail($fieldArr){
		if($fieldArr['uName']){
			$this->mAddressee     = $fieldArr['uName']; //收件人
		}else{
			$this->mAddressee     = $fieldArr['uEmail']; //收件人
		}

		$this->mAddresseeMail = $fieldArr['uEmail']; //收件人邮箱

		$this->uCode     = $fieldArr['uCode'];
		
		switch(strtolower($fieldArr['type'])){
			case 'invitecode': //应用激活邮件
				$rArr['uEmail'] =  $this->mAddresseeMail;
				$rArr['uCode']  =  $this->uCode;
				$rArr['type']   =  'inviteCode';
				
				$aName = $fieldArr['aName'];
				
				$str = ComFun::_encodeArr($rArr);
	
				$this->EmailUrl  = $this->iurl.'/index/activate?data='.$str;
				
				$backEmailArr = include_once($this->contentUrl.'/conf/Email/inviteCode.php');
				break;
			default:
				break;
		}
	//ComFun::pr($backEmailArr);exit;
		$this->mTitle      = $backEmailArr['mTitle'];
		$this->mContent    = $backEmailArr['mContent'];
			
		$this->toSend();
	}
	/**
	 * 用soap方式发送邮件
	 */
	private function toSend() {
		$sendArr = array(
						'UserName'        => $this->UserName,
						'UserPWD'         => $this->UserPWD,
						'mTitle'          => $this->mTitle,
						'mContent'        => $this->mContent,
						'mSender'         => $this->mSender,
						'mSendMail'       => $this->mSendMail,
						'mAddressee'      => $this->mAddressee,
						'mAddresseeMail'  => $this->mAddresseeMail,
						'mIsHTML'         => $this->mIsHTML,
						'SetSendTime'     => $this->SetSendTime
						);

		$client = new SoapClient($this->url);
		$re = $client->SendMail($sendArr);	

		foreach($re as $key=>$val){
			if(strtolower($key) == 'sendmailresult'){
				return $val;
			}else{
				return -1;
			}
		}

		return $re['SendMailResult'];
	}
}
?>
