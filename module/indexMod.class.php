<?php
/**
 *
 * 首页处理
 *
 * @author wbqing405@sina.com
 *
 */

//!DBOwner && header('location:/login/login?ident=manage');

class indexMod extends commonMod {
	/**
	 * index处理
	 */
	public function index() {	
		$this->assign('title', Lang::get('DBOwner'));
		
		//问候语
		$hour = intval(date('H'));
		if(0 <= $hour && $hour < 6){
			$greetings = Lang::get('GreetingsBeforeDawn');
		}elseif(6 <= $hour && $hour < 12){
			$greetings = Lang::get('GreetingsMorning');
		}elseif(12 <= $hour && $hour < 14){
			$greetings = Lang::get('GreetingsMidday');
		}elseif(14 <= $hour && $hour < 18){
			$greetings = Lang::get('GreetingsAfternoon');
		}elseif(18 <= $hour && $hour <= 24){
			$greetings = Lang::get('GreetingsNightEvening');
		}
		$this->assign('greetings', $greetings);
	
		//认证
		/* curl改为内部soap调用
		$tArr['access_token'] = ComFun::getCookies('access_token');
		$re = DBCurl::dbGet($this->config['PLATFORM']['Auth'].'/db/payAuthInfo', 'GET', $tArr);
		*/
		$taArr['user_id'] = ComFun::getCookies('user_id');
		$dbSoap = $this->getClass('DBSoap');
		$re = $dbSoap->GetTableInfo('Auth', 'GetAuthInfo', $taArr);
		
		if($re['data']){
			if($re['data']['uRealName']){
				$auth['realName'] = 1;
			}
			if($re['data']['uSafeEmail'] && $re['data']['uAuthEmail'] == 0){
				$emArr = explode('@', $re['data']['uSafeEmail']);
				$auth['safeEmail'] = substr($re['data']['uSafeEmail'],0,2).'****@'.$emArr[1];
			}
			if($re['data']['uSafePhone']){
				$auth['safePhone'] = substr($re['data']['uSafePhone'],0,3).'****'.substr($re['data']['uSafePhone'],-4);
			}
		}	
		$this->assign('auth', $auth);

		//余额
		//$dbAssets = $this->getClass('DB_Assets');
		$dbCoinDB = $this->getClass('DB_CoinDB');
		//$account['money'] = $dbAssets->getAssetsValue();
		$account['db'] = $dbCoinDB->getCoinDBValue();
		$this->assign('account', $account);
		
		//$listAssets = $dbAssets->getAssetsList('',5,1);
		//$this->assign('listAssets', $listAssets['list']);
		
		$listCoin = $dbCoinDB->getCoinDBList('',5,1);
		$this->assign('listCoin', $listCoin['list']);
		
		//常见问题
		$qlist = array(
					array(
						'title' => '什么是D币',
						'href' => 'http://wiki.dbowner.com/index/document-dbmoney-about_db#what_is_db'	
						),
					array(
							'title' => '服务资费',
							'href' => 'http://wiki.dbowner.com/index/document-dbmoney-about_db#fee'
					),
					array(
							'title' => 'D币赠送',
							'href' => 'http://wiki.dbowner.com/index/document-dbmoney-about_db#free'
					),
					array(
							'title' => 'D币扣除规则',
							'href' => 'http://wiki.dbowner.com/index/document-dbmoney-about_db#deduct'
					),
					array(
							'title' => '如何使用D币',
							'href' => 'http://wiki.dbowner.com/index/document-dbmoney-use_db#pay_db'
					),
					array(
							'title' => 'D币如何充值',
							'href' => 'http://wiki.dbowner.com/index/document-dbmoney-buy_db#buy'
					),
				);
		if( $qlist ){
			foreach($qlist as $key=>$val){
				$qlist[$key]['title'] = msubstr($val['title'],0,28);
			}
		}

		$this->assign('qlist', $qlist);
		$this->assign('jData', array('fee' => $this->config['DB']['Pay']['fee']));
		
		$this->assign('platform_auth', $this->config['PLATFORM']['Auth']);
		$this->display ('index/index.html');
	}
}
?>