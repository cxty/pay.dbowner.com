<?php
/**
 *
 * CURL处理D币
 *
 * @author wbqing405@sina.com
 *
 */
class coinMod extends commonMod {
	/**
	 * 返回信息处理
	 */
	private function _return($data=null) {
		if(isset($data['error'])){
			$data['msg'] = ComFun::getErrorValue($data['error']);
		}
	
		echo json_encode($data);exit;
	}
	/**
	 * 检验请求有效性
	 */
	private function checkValid($access_token){
		if(empty($access_token)){
			$this->_return(array('state' => false,'error' => 'pa10001'));
		}	
	}
	/**
	 * D币总额
	 */
	public function total(){
		$access_token = $_GET['access_token'] ? $_GET['access_token'] : $_POST['access_token'];

		$this->checkValid($access_token); //验证请求的有效性
		
		$tArr['access_token'] = $access_token;
		$tArr['client_id']    = $this->config['oauth']['client_id'];
		
		$_rb = DBCurl::dbGet($this->config['PLATFORM']['Auth'].'/db/checkAccountValid', 'get', $tArr);
		
		if(!$_rb['state']){
			$this->_return(array('state' => false,'error' => 'pa10002'));
		}		
		
		$dbLogin = $this->getClass('DB_Login');		
		$dbCoinDB = $this->getClass('DB_CoinDB');
		$total = $dbCoinDB->getCoinDBValueByUserID($dbLogin->getUserID($_rb['user_id']));
		
		$this->_return(array('state' => true, 'total' => $total));
	}
	/**
	 * 挣取D币
	 */
	public function earn(){
		$access_token = $_GET['access_token'] ? $_GET['access_token'] : $_POST['access_token'];	
		$IdentCode    = $_GET['IdentCode'] ? $_GET['IdentCode'] : $_POST['IdentCode'];
		$platform     = $_GET['platform'] ? $_GET['platform'] : $_POST['platform'];
		$message      = $_GET['message'] ? $_GET['message'] : $_POST['message'];
		$db           = $_GET['db'] ? $_GET['db'] : $_POST['db'];
		
		if(!$db){
			$this->_return(array('state' => false,'error' => 'pa10003'));
		}
		
		$this->checkValid($access_token); //验证请求的有效性
		
		$tArr['access_token'] = $access_token;
		$tArr['IdentCode']    = $IdentCode;
		$tArr['client_id']    = $this->config['oauth']['client_id'];
		
		$_rb = DBCurl::dbGet($this->config['PLATFORM']['Auth'].'/db/getCoinUserID', 'get', $tArr);
		
		if(!$_rb['state']){
			$this->_return(array('state' => false,'error' => 'pa10002'));
		}	
		
		$dbLogin = $this->getClass('DB_Login');
		$dbCoinDB = $this->getClass('DB_CoinDB');
		
		//双方用户对应平台ID
		$identUser = $dbLogin->getUserID($_rb['identUser']);
		$tokenUser = $dbLogin->getUserID($_rb['tokenUser']);
		
		//验证当前消费用户是否有足够的数额
		$total = $dbCoinDB->getCoinDBValueByUserID($identUser); 
		if((intval($total)-intval($db)) < 0){
			$this->_return(array('state' => false,'error' => 'pa10004'));
		}
		
		if($platform){
			$GLOBALS["config"]['PLATFORM']['Now'] = $platform;		
		}
		$GLOBALS["config"]['PLATFORM']['DB'] = '2'; //2为DB交易		
			
		unset($tArr);
		//App应用消费
		$tArr['UserID'] = $identUser;
		$tArr['dState'] = $message;
		$tArr['CoinDB'] = $db;
		$tArr['dType']  = 4; //消耗
		$dbCoinDB->addCoinDBInfoByUserID($tArr);

		unset($tArr);
		//用户挣取
		$tArr['UserID'] = $tokenUser;
		$tArr['dState'] = $message;
		$tArr['CoinDB'] = $db;
		$tArr['dType']  = 3; //挣取
		$dbCoinDB->addCoinDBInfoByUserID($tArr);
		
		$this->_return(array('state' => true, 'msg' => 'success'));
	}
	/**
	 * 消费D币
	 */
	public function consume(){
		$TokenCode    = $_GET['TokenCode'] ? $_GET['TokenCode'] : $_POST['TokenCode'];
		$IdentCode    = $_GET['IdentCode'] ? $_GET['IdentCode'] : $_POST['IdentCode'];
		$platform     = $_GET['platform'] ? $_GET['platform'] : $_POST['platform'];
		$message      = $_GET['message'] ? $_GET['message'] : $_POST['message'];
		$db           = $_GET['db'] ? $_GET['db'] : $_POST['db'];
		
		if(!$db){
			$this->_return(array('state' => false,'error' => 'pa10003'));
		}
		
		$tArr['TokenCode']    = $TokenCode;
		$tArr['IdentCode']    = $IdentCode;
		$tArr['client_id']    = $this->config['oauth']['client_id'];
		
		$_rb = DBCurl::dbGet($this->config['PLATFORM']['Auth'].'/db/getCoinTokenID', 'get', $tArr);
		
		if(!$_rb['state']){
			$this->_return(array('state' => false,'error' => 'pa10005'));
		}
		
		$dbLogin = $this->getClass('DB_Login');
		$dbCoinDB = $this->getClass('DB_CoinDB');
		
		//双方用户对应平台ID
		$identUser = $dbLogin->getUserID($_rb['identUser']);
		$tokenUser = $dbLogin->getUserID($_rb['tokenUser']);
		
		//验证当前消费用户是否有足够的数额
		$total = $dbCoinDB->getCoinDBValueByUserID($identUser);
		if((intval($total)-intval($db)) < 0){
			$this->_return(array('state' => false,'error' => 'pa10004'));
		}
		
		if($platform){
			$GLOBALS["config"]['PLATFORM']['Now'] = $platform;
		}
		$GLOBALS["config"]['PLATFORM']['DB'] = '2'; //2为DB交易
			
		unset($tArr);
		//App应用挣取
		$tArr['UserID'] = $identUser;
		$tArr['dState'] = $message;
		$tArr['CoinDB'] = $db;
		$tArr['dType']  = 3; //挣取
		$dbCoinDB->addCoinDBInfoByUserID($tArr);
		
		unset($tArr);
		//广告主消费
		$tArr['UserID'] = $tokenUser;
		$tArr['dState'] = $message;
		$tArr['CoinDB'] = $db;
		$tArr['dType']  = 4; //消耗
		$dbCoinDB->addCoinDBInfoByUserID($tArr);
		
		$this->_return(array('state' => true, 'msg' => 'success'));
	}
}