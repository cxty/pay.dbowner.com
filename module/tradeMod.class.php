<?php
/**
 *
 * 交易管理
 *
 * @author wbqing405@sina.com
 *
 */

//!DBOwner && header('location:/login/login?ident=manage');

class tradeMod extends commonMod {
	/**
	 * 导航
	 */
	private function tradeNav(){
		return array(
				array('name' => Lang::get('DetailTradeDB'), 'url' => '/trade/db', 'view' => 'db'),
				//array('name' => Lang::get('DetailTradeCash'), 'url' => '/trade/cash', 'view' => 'cash'),				
				array('name' => Lang::get('DetailTakeMoney'), 'url' => '/trade/wait', 'view' => 'wait'),
				
		);
	}
	/**
	 * 现金明细
	 */
	public function cash(){
		$this->assign('title', Lang::get('DBOwner'));
		
		$tradeNav = $this->tradeNav();
		
		$dbAssets = $this->getClass('DB_Assets');
		$page = $_GET['page'];
		$pagesize = 10;
		$listInfo = $dbAssets->getAssetsList($_POST, $pagesize, $page);
		$this->assign('listInfo', $listInfo['list']);
		$this->assign('showpage', $this->showpage('/trade/cash', $listInfo['count'], $pagesize));
		
		
		$this->assign('tradeNav', $tradeNav);
		$this->assign('jsonData', json_encode(array(
										'tradeNav' => $tradeNav,
										'view' => $_GET['_action']
									)));
		$this->display('trade/cash.html');
	}
	/**
	 * 转账
	 */
	public function wait(){
		$this->assign('title', Lang::get('DBOwner'));
	
		$tradeNav = $this->tradeNav();
	
		$dbCoinDB = $this->getClass('DB_CoinDB');
		$page = $_GET['page'];
		$pagesize = 10;

		$tArr['startTime'] = $_GET['startTime'];
		$tArr['endTime']   = $_GET['endTime'];
		if($_GET['tradeType'] == 1){
			$tArr['Status'] = '1';
		}elseif( ($_GET['tradeType'] == 2) || ($_GET['tradeType'] == 3) ){
			$tArr['Status'] = '0,2';
		}
		$tArr['dType'] = 2;
		//$listInfo = $dbAssets->getwithdrawList($_POST, $pagesize, $page);
		$listInfo = $dbCoinDB->getCoinDBList($tArr, $pagesize, $page);
		if($listInfo['list']){
			foreach($listInfo['list'] as $key=>$val){
				$listInfo['list'][$key]['CoinDB'] = sprintf("%.2f", ($val['CoinDB'] / $this->config['DB']['Pay']['ExchangeRate'] ) );
			}
		}
		$this->assign('listInfo', $listInfo['list']);
		$this->assign('showpage', $this->showpage('/trade/wait?'.ComFun::makeCallBack($_GET), $listInfo['count'], $pagesize));
	
	
		$this->assign('tradeNav', $tradeNav);
		$this->assign('jsonData', json_encode(array(
				'tradeNav' => $tradeNav,
				'view' => $_GET['_action']
		)));
		$this->display('trade/wait.html');
	}
	/**
	 * D币明细
	 */
	public function db(){
		$this->assign('title', Lang::get('DBOwner'));
		
		$tradeNav = $this->tradeNav();
		
		$dbCoinDB = $this->getClass('DB_CoinDB');
		$page = $_GET['page'];
		$pagesize = 10;		

		$listInfo = $dbCoinDB->getCoinDBList($_GET, $pagesize, $page);
		$this->assign('listInfo', $listInfo['list']);
		$this->assign('showpage', $this->showpage('/trade/db?'.ComFun::makeCallBack($_GET), $listInfo['count'], $pagesize));
		
		
		$this->assign('tradeNav', $tradeNav);
		$this->assign('jsonData', json_encode(array(
										'tradeNav' => $tradeNav,
										'view' => $_GET['_action']
									)));
		
		$this->display('trade/db.html');
	}
}
?>