<?php
/**
 *
 * 现金和D币转化管理
 *
 * @author wbqing405@sina.com
 *
 */

//!DBOwner && header('location:/login/login?ident=manage');

class assetsMod extends commonMod {
	/**
	 * 充值
	 */
	public function deposit(){
		
	}
	/**
	 * 进行充值跳转
	 */
	public function payment(){	
		//为生成流水号做准备
		$fieldArr['Now']         = '007'; //pay平台
		$fieldArr['DB']          = '1'; //现金交易
		$SerialCode = ComFun::getSerialCodeNum($fieldArr);
		
		$payCommon = $this->getClass('PayCommon');
		$paytype = strtolower($_GET[0]);
		$GLOBALS['config']['pay']['paytype'] = $paytype;
		
		$cookies['pay_SerialCode'] = $SerialCode;
		$cookies['paytype']        = $paytype;
		$cookies['feetype']        = $_GET[2];

		switch($paytype){
			case 'alipay':
				$cookies['pay_total']      = $_GET[1];
				ComFun::SetCookies($cookies);
				
				$tArr['total_fee']    = $_GET[1];
				$tArr['out_trade_no'] = $SerialCode;
				$tArr['subject']      = Lang::get('DBOwnerRecharge'); 
				$tArr['body']         = Lang::get('DBOwnerBody');
				$rb = $payCommon->payment($tArr);
				break;
			case 'paypal':
				$tArr['total'] = $_GET[1];
				$rb = $payCommon->payment($tArr);				
				
				$cookies['pay_total']      = $_GET[2];
				
				ComFun::SetCookies($cookies);
				break;
			default:
				$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayParamError'));
				break;
		}
		
		if( $rb['status'] ){
			$url = $rb['url'];
		}else{
			$url = '/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayError');
		}
			
		$this->redirect( $url );
	}
	/**
	 * 增加充值记录
	 */
	public function adddeposit(){
		
	}
	/**
	 * 取现
	 */
	public function withdraw(){
		
	}
	/**
	 * 增加体现记录
	 */
	public function addwithdraw(){	
		
	}
	/**
	 * 转DB
	 */
	public function change(){
		$this->assign('title', Lang::get('DBOwner'));

		if( $_GET[0] ){
			$account['coin_num'] = $this->config['DB']['Pay']['fee']/$this->config['DB']['Pay']['ExchangeRate'];
			$account['db_num'] = $this->config['DB']['Pay']['fee'];
		}
		
		//余额
		$dbCoinDB = $this->getClass('DB_CoinDB');
		$account['db'] = $dbCoinDB->getCoinDBValue();
		$account['rate'] = $this->config['DB']['Pay']['ExchangeRate'];
		$this->assign('account', $account);
		$this->assign('jsonData', json_encode(array(
										'type' => $_GET[0] ? $_GET[0] : 'common',
										'db' => $account['db'],
										'rate' => $this->config['DB']['Pay']['ExchangeRate'],
										'parities' => $account['rate'] = DBCurl::getRate($this->config['ExchangeRate_url'], 'POST', array('FromCurrency' => 'USD','ToCurrency' => 'CNY')),
									)));
		
		$this->display ('assets/change.html');
	}
	/**
	 * 增加D币充值记录
	 */
	public function addChange(){	
	
	}
	/**
	 * 折现
	 */
	public function discounting(){
		$this->assign('title', Lang::get('DBOwner'));
		
		//余额
		$dbCoinDB = $this->getClass('DB_CoinDB');

		$account = array(
				'db' => $dbCoinDB->getCoinDBValue(),
				'rate' => $this->config['DB']['Pay']['ExchangeRate'],
				'factorage' => $this->config['DB']['Pay']['factorage'],
				'withdrawNumDB' => $this->config['DB']['Pay']['withdrawNum'] * $this->config['DB']['Pay']['ExchangeRate'],
				'coinLimitSmall' => $this->config['DB']['Pay']['coinLimitSmall'],
				'coinLimitBig' => $this->config['DB']['Pay']['coinLimitBig'],
				'smallCoinNum' => $this->config['DB']['Pay']['coinLimitSmall'] / $this->config['DB']['Pay']['factorage'],
				'bigCoinNum' => $this->config['DB']['Pay']['coinLimitBig'] / $this->config['DB']['Pay']['factorage'],
				);
	
		$this->assign('account', $account);
		$this->assign('jsonData', json_encode($account));
		
		$this->display ('assets/discounting.html');
	}
	/**
	 * 增加D币充值记录
	 */
	public function adddiscounting(){
		$dbCoinDB = $this->getClass('DB_CoinDB');

		$CoinDB = intval($_GET[0]);
		if( !$CoinDB ){
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('NotNullMoneyCoin10003'));
		}
		if( $CoinDB > $dbCoinDB->getCoinDBValue() ){
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('NotNullMoneyCoinTotal10004'));
		}
		
		//为生成流水号做准备
		$fieldArr['Now']         = '007'; //pay平台
		$fieldArr['DB']          = '1'; //现金交易
		$SerialCode = ComFun::getSerialCodeNum($fieldArr);
		//现金转化D币增加
		$tArr['dState']       = Lang::get('DiscountingChange');
		$tArr['dSerialCode']  = $SerialCode;
		$tArr['CoinDB']       = $CoinDB;
		$tArr['dType']        = 2; //折现

		$dbCoinDB->addCoinDBInfo($tArr);

		$this->redirect('/trade/db');
	}
}
?>