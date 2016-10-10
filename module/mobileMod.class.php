<?php
/**
 *
 * 手机支付页面
 *
 * @author wbqing405@sina.com
 *
 */

class mobileMod extends commonMod {
	
	public function change () {
		//余额
		$dbCoinDB = $this->getClass('DB_CoinDB');
		$account['db'] = $dbCoinDB->getCoinDBValue();
		$account['rate'] = $this->config['DB']['Pay']['ExchangeRate'];
		$this->assign('account', $account);
		$this->assign('jsonData', json_encode(array(
				'type' => $_GET[0] ? $_GET[0] : 'common',
				'db' => $account['db'],
				'rate' => $this->config['DB']['Pay']['ExchangeRate'],
				//'parities' => $account['rate'] = DBCurl::getRate($this->config['ExchangeRate_url'], 'POST', array('FromCurrency' => 'USD','ToCurrency' => 'CNY')),
		)));
		
		$this->display ('mobile/change.html');
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
	
		$total_fee = intval($_GET[1]);
		
		if ( $total_fee <= 0 ) {
			echo '<script>
					alert(\'' . Lang::get('ChargeGreaterThanZero') . '\');
					history.back();
					</script>';exit;
		}

		switch ( strtolower($paytype) ) {
			case 'alipay':
				$cookies['pay_total']      = $total_fee;
				ComFun::SetCookies($cookies);
	
				$tArr['mobile']       = true;
				$tArr['total_fee']    = $total_fee;
				$tArr['out_trade_no'] = $SerialCode;
				$tArr['subject']      = Lang::get('DBOwnerRecharge');
				$tArr['body']         = Lang::get('DBOwnerBody');
				$rb = $payCommon->payment($tArr);
				ComFun::pr($rb);exit;
				break;
			case 'paypal':
				$tArr['total'] = $total_fee;
				$rb = $payCommon->payment($tArr);
	
				$cookies['pay_total']      = $total_fee;
	
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
	 * 成功支付
	 */
	public function success () {
		echo '成功支付';
	}
	
	/**
	 * 取消支付
	 */
	public function notify () {
		echo '取消支付';
	}
	
	/**
	 * 中断支付
	 */
	public function merchant () {
		echo '中断支付';
	}
}