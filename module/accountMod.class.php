<?php
/**
 *
 * 账号管理
 *
 * @author wbqing405@sina.com
 *
 */

//!DBOwner && header('location:/login/login?ident=manage');

class accountMod extends commonMod {
	/**
	 * 导航
	 */
	private function tradeNav(){
		return array(
				array('name' => Lang::get('DetailAccountFinance'), 'url' => '/account/finance', 'view' => 'finance'),
		);
	}
	/**
	 * index处理
	 */
	public function finance() {	
		$this->assign('title', Lang::get('DBOwner'));
		
		$dbAccountMsg = $this->getClass('DB_AccountMsg');
		$listInfo = $dbAccountMsg->getAccountBaseInfoByUserID(ComFun::getCookies('UserID'));

		$this->assign('listInfo', $listInfo);
		$tradeNav = $this->tradeNav();
		$this->assign('tradeNav', $tradeNav);
		$this->assign('jsonData', json_encode(array(
				'tradeNav' => $tradeNav,
				'view' => $_GET['_action']
		)));
		$this->display ('account/finance.html');
	}
	/**
	 * 增加
	 */
	public function add(){
		$tArr['UserID']         = ComFun::getCookies('UserID');
		$tArr['aType']          = $_POST['aType'];
		$tArr['aUserName']      = $_POST['aUserName'];
		$tArr['aAccountNumber'] = $_POST['aAccountNumber'];
		
		$dbAccountMsg = $this->getClass('DB_AccountMsg');
		if($_POST['AutoID']){
			$tArr['AutoID']  = $_POST['AutoID'];
			
			$dbAccountMsg->modifyAccountBase($tArr);
		}else{	
			$dbAccountMsg->addAccountBase($tArr);
		}	

		$this->redirect( '/account/finance' );
	}
}
?>