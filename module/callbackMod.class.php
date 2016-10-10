<?php
/**
 *
 * 支付返回地址处理
 *
 * @author wbqing405@sina.com
 *
 */
class callbackMod extends commonMod {
	/**
	 * 成功支付之后，返回页面
	 */
	public function success(){
		$paytype = strtolower(ComFun::getCookies('paytype'));
		$GLOBALS['config']['pay']['paytype'] = $paytype;
		$payCommon = $this->getClass('PayCommon');
		
		switch( $paytype ){
			case 'alipay':
				$tArr['body']         = $_GET['body'];
			    $tArr['buyer_email']  = $_GET['buyer_email'];
			    $tArr['buyer_id']     = $_GET['buyer_id'];
			    $tArr['exterface']    = $_GET['exterface'];
			    $tArr['is_success']   = $_GET['is_success'];
			    $tArr['notify_id']    = $_GET['notify_id'];
			    $tArr['notify_time']  = $_GET['notify_time'];
			    $tArr['notify_type']  = $_GET['notify_type'];
			    $tArr['out_trade_no'] = $_GET['out_trade_no'];
			    $tArr['payment_type'] = $_GET['payment_type'];
			    $tArr['seller_email'] = $_GET['seller_email'];
			    $tArr['seller_id']    = $_GET['seller_id'];
			    $tArr['subject']      = $_GET['subject'];
			    $tArr['total_fee']    = $_GET['total_fee'];
			    $tArr['trade_no']     = $_GET['trade_no'];
			    $tArr['trade_status'] = $_GET['trade_status'];
			    $tArr['sign']         = $_GET['sign'];
			    $tArr['sign_type']    = $_GET['sign_type'];
	
				$verify_result = $payCommon->execute($tArr);

				$email = $_GET['buyer_email'];
				break;
			case 'paypal':
				$tArr['payer_id'] = $_GET['PayerID'];
				$rb = $payCommon->execute($tArr);

				$verify_result = $rb['status'];
				break;
			default:
				$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayPayWrong'));
				break;
		}

		$CoinDB = $_COOKIE['pay_total'] ? ComFun::getCookies('pay_total') : 0;
		
		if(!$CoinDB){
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('NotNullState10002'));
		}
		
		if( $verify_result ){
			$t2Arr['dState']          = $paytype.Lang::get('Recharge');
			$t2Arr['dSerialCode']     = ComFun::getCookies('pay_SerialCode');
			$t2Arr['CoinDB']          = $CoinDB*$this->config['DB']['Pay']['ExchangeRate'];
			$t2Arr['dType']           = 1; //充值
			$t2Arr['dBuyPlatform']    = $paytype;
			$t2Arr['dBuyEmail']       = $email;
			$t2Arr['dBuyAttached']    = json_encode($_GET);
			
			$dbCoinDB = $this->getClass('DB_CoinDB');
			$dbCoinDB->addCoinDBInfo($t2Arr);
			
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayPaySuccess').'-'.ComFun::__encrypt(1).'-'.ComFun::__encrypt('/trade/db'));
		}else{
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayCheckWrong'));
		}		
	}
	/**
	 * 取消支付之后，返回的页面
	 */
	public function cancel(){
		$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayCancel'));
	}
	/**
	 * 提现成功之后，返回的页面
	 */
	public function notify(){
		$tArr['notify_time']     = $_POST['notify_time'];
		$tArr['notify_type']     = $_POST['notify_type'];
		$tArr['notify_id']       = $_POST['notify_id'];
		$tArr['sign_type']       = $_POST['sign_type'];
		$tArr['sign']            = $_POST['sign'];
		$tArr['batch_no']        = $_POST['batch_no'];
		$tArr['pay_account_no']  = $_POST['pay_account_no'];
		$tArr['pay_user_id']     = $_POST['pay_user_id'];
		$tArr['pay_user_name']   = $_POST['pay_user_name'];
		$tArr['success_details'] = $_POST['success_details'];
		$tArr['fail_details']    = $_POST['fail_details'];
			
		/*
		 $fp = fopen("test.txt", "w");//文件被清空后再写入
			
		$flag=fwrite($fp, json_encode($tArr));
			
		fclose($fp);
		*/
			
		$dbCoinDB = $this->getClass('DB_CoinDB');
			
		if($_POST['success_details']){
			$success_details = explode('|', $_POST['success_details']);
			foreach($success_details as $key=>$val){
				if($val){
					$deArr = explode('^', $val);
					$sArr['dSerialCode']    = $deArr[0];
					$sArr['Status']         = 1;
					$sArr['dPayState']      = json_encode($tArr);
					$sArr['dPaySerialCode'] = $tArr['batch_no'];
					$dbCoinDB->changeWithdraw($sArr);
				}
			}
		}
		
		if($_POST['fail_details']){
			$fail_details = explode('|', $_POST['fail_details']);
			foreach($fail_details as $key=>$val){
				if($val){
					$deArr = explode('^', $val);
					$fArr['dSerialCode']    = $deArr[0];
					$fArr['Status']         = 2;
					$fArr['dPayState']      = json_encode($tArr);
					$fArr['dPaySerialCode'] = $tArr['batch_no'];
					$dbCoinDB->changeWithdraw($fArr);
				}
			}
		}
			
		echo "success";		//请不要修改或删除
		
		exit;
		$payCommon = $this->getClass('PayCommon');
		
		$verify_result = $payCommon->execute($tArr);

		if($verify_result) {//验证成功
			
			echo "success";		//请不要修改或删除
		}else {
			//验证失败
			echo "fail";
		
			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	/**
	 * 转账处理
	 */
	public function account(){		
		if( $_GET[0] ){
			$dbCoinDB = $this->getClass('DB_CoinDB');
			
			$id = ComFun::soap_decrypt( $_GET[0] );
			
			if($id){
				
				$idStr = implode(',', explode('|',  $id) );
				$re = $dbCoinDB->getWaitWithdrawByID( $idStr );
		
				if( $re ){
					//支付宝支付所需3参数
					$batch_fee_1 = 0;
					$batch_num_1 = 0;
					$detail_data_1 = '';
					foreach( $re as $key=>$val ){
							
						switch( intval( $val['aType'] ) ){
							case 1:
								$CoinDB = sprintf( "%.2f", ( $val['CoinDB'] / $this->config['DB']['Pay']['ExchangeRate'] ) );
								$batch_fee_1 += $CoinDB;
								$batch_num_1 ++;
								if($detail_data_1 == ''){
									$detail_data_1 = $val['dSerialCode'].'^'.$val['aAccountNumber'].'^'.$val['aUserName'].'^'.$CoinDB.'^'.Lang::get('DBOwnerWithdraw');
								}else{
									$detail_data_1 .= '|'.$val['dSerialCode'].'^'.$val['aAccountNumber'].'^'.$val['aUserName'].'^'.$CoinDB.'^'.Lang::get('DBOwnerWithdraw');
								}
								break;
						}
							
					}
				}
					
				$payCommon = $this->getClass('PayCommon');
		
				if( $batch_fee_1 ){
					//更新指定转账条目状态
					$dbCoinDB->updateWithdrawingByID( $idStr );
					
					//支付宝支付
					$GLOBALS['config']['pay']['paytype'] = 'alipay';
					$tArr['batch_fee'] = $batch_fee_1;
					$tArr['batch_num'] = $batch_num_1;
					$tArr['detail_data'] = $detail_data_1;
					
					$payCommon->withdraw($tArr);
				}else{
					$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayAccount').'-'.ComFun::__encrypt('2'));
				}
			}
		}else{
			$this->redirect('/throwMessage/throwMsg-'.ComFun::__encrypt('TWPayLackParams').'-'.ComFun::__encrypt('2'));
		}
	}
}