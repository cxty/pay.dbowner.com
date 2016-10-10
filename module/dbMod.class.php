<?php
/**
 *
 * db内部处理类
 *
 * @author wbqing405@sina.com
 *
 */
class dbMod extends commonMod {
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
	 * 解密数据的有效性
	 */
	public function decryptCoinRandom(){
		$code        = $_GET['code'] ? $_GET['code'] : $_POST['code'];
		$UserID      = $_GET['UserID'] ? $_GET['UserID'] : $_POST['UserID'];
		$serialCode  = $_GET['serialCode'] ? $_GET['serialCode'] : $_POST['serialCode'];
		$coin        = $_GET['coin'] ? $_GET['coin'] : $_POST['coin'];
		$type        = $_GET['type'] ? $_GET['type'] : $_POST['type'];
		$AppendTime  = $_GET['AppendTime'] ? $_GET['AppendTime'] : $_POST['AppendTime'];	
		
		if(empty($code)){
			$this->_return(array('state' => false,'error' => 'pacode10001'));
		}
		if(empty($UserID)){
			$this->_return(array('state' => false,'error' => 'pacode10002'));
		}
		if(empty($serialCode)){
			$this->_return(array('state' => false,'error' => 'pacode10003'));
		}
		if(empty($coin)){
			$this->_return(array('state' => false,'error' => 'pacode10004'));
		}
		if(empty($type)){
			$this->_return(array('state' => false,'error' => 'pacode10005'));
		}
		if(empty($AppendTime)){
			$this->_return(array('state' => false,'error' => 'pacode10006'));
		}

		try{
			$_re = DBRandomHash::decryptRandomString($serialCode, $code);
			
			if($_re){
				$_ra = explode('|', $_re);

				if($_ra[0] == $AppendTime &&
					    $_ra[1] == $coin &&
						$_ra[2] == $serialCode &&
						$_ra[3] == $type &&
						$_ra[4] == $UserID){
					$_rb = true;
				}else{
					$_rb = false;
				}
			}else{
				$_rb = false;
			}
		}catch(Exception $e){
			$_rb = false;
		}
		
		$this->_return(array('state' => true, 'msg' => $_rb));
	}
}