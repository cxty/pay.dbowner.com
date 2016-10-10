<?php
/**
 *
 * CURL处理D币
 *
 * @author wbqing405@sina.com
 *
 */
class testMod extends commonMod {
	public function test(){
		//exit;
		$a = 'cGS6/uUOmFk=';
		
		echo $a;
		echo '<br>';
		
		echo ComFun::soap_decrypt($a);
		
		//exit;
		echo '<br>';
		$id = '65';
		
		echo ComFun::soap_encrypt($id);
		echo '<br>';
		$url = 'http://tpay.dbowner.com/callback/account-'.ComFun::soap_encrypt($id);
		
		echo $id;
		echo '<br>';
		echo $url;
		
		exit;
		
		
		
// 		$id = '1|10|68';
// 		$_id = ComFun::_encrypt($id);
		
// 		echo $id;
// 		echo '<br>';
// 		echo $_id;
		
// 		exit;
		$payCommon = $this->getClass('PayCommon');

		$GLOBALS['config']['pay']['paytype'] = 'alipay';
		
		$tArr['batch_fee'] = 0.01;
		$tArr['batch_num'] = 1;
		$tArr['detail_data'] = '20130809160830489907000071965999'.'^'.'379182261@qq.com'.'^'.'吴本清'.'^'.'0.01'.'^'.Lang::get('DBOwnerWithdraw');

		$payCommon->withdraw($tArr);

	}
	public function server(){
		exit;
		include(dirname(dirname(__FILE__)).'/include/api/DBOwnerPay.php');
		$DBOwnerPay = new DBOwnerPay();
		$info = $DBOwnerPay->SelectUserInfo('aaaa');
		ComFun::pr($info);
	}
	public function soap(){
		exit;
		$type = 'Pay';
		$tableName = 'DBTradeLogInfo';
		$condition = '';
		$DBSoap = new DBSoap();
		
		echo '==========table=========<br>';
		echo $tableName;
		
		echo '<br>==========select==========<br>';
		$re = $DBSoap->SelectTableInfo($type, 'Select'.$tableName, $condition);
		ComFun::pr($re);
		//exit;
		echo '<br>==========list==========<br>';
		$condition = '';
		$re = $DBSoap->SelectTableInfo($type, 'Get'.$tableName.'List', $condition);
		ComFun::pr($re);
	}
	public function curl(){
		exit;
		$url = $this->config['PLATFORM']['Secret'];
		//$url .= '/authcode/getCoinRandomCode';
		$url .= '/authcode/decryptCoinRandom';
		
		$tArr['code']        = 'OGxiSUF5Z3VqaURFVzcxdWhGS1R5NnVSOEtwZ25mVUtUK0dMUFBsMEoraDlITHdCdmJncUNBdXZrTFFjcnJGLzVvZXRVMUl5SGd3PQ%3D%3D';
		$tArr['UserID']      = 1;
		$tArr['serialCode']  = '20130516125250968536000042080817';
		$tArr['coin']        = 300;
		$tArr['type']        = 3;
		$tArr['AppendTime']  = '1368679970';
		
		// 		$url .= '?'.http_build_query($tArr);
		// 		echo $url;
		$re = DBCurl::dbGet($url, 'get', $tArr);
		ComFun::pr($re);
		exit;
		$url = 'http://tpay.dbowner.com';
		$url .= '/coin/earn';

		$tArr['access_token']   = ComFun::getCookies('access_token');
		$tArr['IdentCode']      = 'eTNBSUkzT1YxOXc9';
		$tArr['platform']       = '004';
		$tArr['message']        = '测试';
		$tArr['db']             = 300;
		
		//echo $url.'?'.http_build_query($tArr);exit;
		
		$re = DBCurl::dbGet($url, 'get', $tArr);
		
		ComFun::pr($re);
	}
}