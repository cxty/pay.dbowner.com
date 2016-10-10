<?php
/**
 * SOAP服务器处理类
*
* @author wbqing405@sina.com
*/
include('Server.class.php');

class DBOwnerPay extends Server{

	var $tbUserInfo = 'tbUserInfo'; //用户授权信息
	var $tbAssetsTradeInfo = 'tbAssetsTradeInfo'; //现金交易信息表
	var $tbAssetsTradeLogInfo = 'tbAssetsTradeLogInfo'; //现金交易记录表
	var $tbDBTradeInfo = 'tbDBTradeInfo'; //D币交易信息表
	var $tbDBTradeLogInfo = 'tbDBTradeLogInfo'; //D币交易记录表
	var $tbAccountBaseInfo = 'tbAccountBaseInfo'; //财务信息
	
	public $authorized = false;

	public function __construct($model=null){
		$this->model = $model;
		include(dirname(dirname(dirname(__FILE__))).'/conf/config.php');
		$this->config      = $config;
		
		$this->SOAP_USER   = $this->config['DES']['SOAP_USER'];
		$this->DES_PWD     = $this->config['DES']['SOAP_PWD'];
		$this->DES_IV      = $this->config['DES']['SOAP_IV'];
		$this->user        = $this->config['DES']['SOAP_USER'];

		$this->ClientIP = parent::fun()->GetIP ();
		
		if (! in_array ( $this->ClientIP, $this->config ['DES']['SOAP_SERVER_CLIENTIP'] )) {
			$this->authorized = false;
			return parent::Unauthorized_IP();
		}
	}

	/**
	 * 接口鉴权
	 *
	 * @param array $a
	 * @throws SoapFault
	 */
	public function Auth($a) {
		if ($a->user === $this->user) {
			$this->authorized = true;
			return $this->_return ( true, 'OK', null );
		} else {
			return parent::Unauthorized_User();
		}
	}
	/**
	 * 负责data加密
	 *
	 * @see Service::_return()
	 */
	public function _return($state, $msg, $data) {
		return parent::_return ( $state, $msg,
				$this->_encrypt ( json_encode(array('data'=>$data)),
						$this->DES_PWD, $this->DES_IV ) );
	}
	/**
	 * 负责解密data,还原客户端传来的参数
	 */
	public function _value($data) {
		if (isset ( $data )) {
			return json_decode ( trim ( $this->_decrypt ( $data, $this->DES_PWD , $this->DES_IV ) ) );
		} else {
			return $data;
		}
	}
	/**
	 * 数组转化
	 */
	public function arrAddslashes($data){
		foreach($data as $key=>$val){
			$rb[$key] = parent::_addslashes($val);
		}
		return $rb;
	}
	/**
	 * 字符串转化
	 */
	public function strAddslashes($str){
		return parent::_addslashes($str);
	}
	/**
	 * 数据库连接
	 */
	public function requireConnect(){
		$this->connect = parent::RequireClass($this->model);
	}
	
	/**
	 * 链接数据库
	 */
	private function _connect(){
		$this->_getConnect = parent::getConnect();
	}
	
	//=====以下是后台调用接口=====
	//用户信息
	/**
	 * 取信息
	 * 
	 * 注意：多表连接(tbUserInfo=>a,tbAssetsTradeInfo=>b,tbDBTradeInfo=>c)
	 */
	public function SelectUserInfo($pa){
		if($this->authorized){		
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);

				$field = 'a.user_id,a.uName,ifnull(b.Assets,0) as Assets,ifnull(c.CoinDB,0) as CoinDB,a.Status,a.AppendTime,a.UpdateTime';
				
				$sql = 'select '.$field.' from '.$this->tbUserInfo.' as a left join '.$this->tbAssetsTradeInfo.' as b on a.AutoID = b.UserID ';
				$sql .= ' left join '.$this->tbDBTradeInfo.' as c on a.AutoID = c.UserID ';
				
				if($data->condition){
					$sql .= ' where '.$data->condition;
				}
				if($data->order){
					$sql .= ' order by '.$data->order;
				}

				$rb = $exp->getQueryData($sql);
				
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	/**
	 * 取列表
	 * 
	 * 注意：多表连接(tbUserInfo=>a,tbAssetsTradeInfo=>b,tbDBTradeInfo=>c)
	 */
	public function GetUserInfoList($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
				
				$field = 'a.user_id,a.uName,ifnull(b.Assets,0) as Assets,ifnull(c.CoinDB,0) as CoinDB,a.Status,a.AppendTime,a.UpdateTime';
				
				$sql = 'select '.$field.' from '.$this->tbUserInfo.' as a left join '.$this->tbAssetsTradeInfo.' as b on a.AutoID = b.UserID ';
				$sql .= ' left join '.$this->tbDBTradeInfo.' as c on a.AutoID = c.UserID ';
				if($data->condition){
					$sql .= ' where '.$data->condition;
				}
				if($data->order){
					$sql .= ' order by '.$data->order;
				}
				
	
				$rb = $exp->getQueryListData($sql, $this->tbUserInfo,parent::getListPage($data->page),parent::getListPageSize($data->pagesize), $data->condition);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	//=====以下是后台调用接口=====
	//财务信息
	/**
	 * 取信息
	 */
	public function SelectAccountBaseInfo($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
				
				$exp = parent::RequireClass($this->model);
	
				$field = 'AutoID,UserID,aType,aUserName,aAccountNumber,Status,AppendTime,UpdateTime';
				
				$rb = $exp->seTableData($this->tbAccountBaseInfo, $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	/**
	 * 取列表
	 */
	public function GetAccountBaseInfoList($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
	
				$field = 'AutoID,UserID,aType,aUserName,aAccountNumber,Status,AppendTime,UpdateTime';
	
				if(!$data->order){
					$data->order = 'UpdateTime desc';
				}
				
				$rb = $exp->geTableData($this->tbAccountBaseInfo, parent::getListPage($data->page), parent::getListPageSize($data->pagesize), $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	//用户的现金交易记录
	/**
	 * 取信息
	 *
	 */
	public function SelectAssetsTradeLogInfo($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
	
				$field = 'UserID,cSerialCode,cState,Assets,cType,cRandomCode,AppendTime,UpdateTime';
	
				if(!$data->order){
					$data->order = 'UpdateTime desc';
				}
				
				$rb = $exp->seTableData($this->tbAssetsTradeLogInfo, $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	/**
	 * 取列表
	 */
	public function GetAssetsTradeLogInfoList($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
	
				$field = 'UserID,cSerialCode,cState,Assets,cType,cRandomCode,AppendTime,UpdateTime';
	
				if(!$data->order){
					$data->order = 'UpdateTime desc';
				}
				
				$rb = $exp->geTableData($this->tbAssetsTradeLogInfo, parent::getListPage($data->page), parent::getListPageSize($data->pagesize), $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	//用户的D币交易记录
	/**
	 * 取信息
	 *
	 */
	public function SelectDBTradeLogInfo($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
	
				$field = 'AutoID,UserID,dSerialCode,dState,CoinDB,dType,dRandomCode,dRandomCode,dBuyPlatform,dBuyEmail,dBuyAttached,dPayState,dPaySerialCode,Status,AppendTime,UpdateTime';
				
				if(!$data->order){
					$data->order = 'UpdateTime desc';
				}
				
				$rb = $exp->seTableData($this->tbDBTradeLogInfo, $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	/**
	 * 取列表
	 */
	public function GetDBTradeLogInfoList($pa){
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				$exp = parent::RequireClass($this->model);
	
				$field = 'AutoID,UserID,dSerialCode,dState,CoinDB,dType,dRandomCode,dRandomCode,dBuyPlatform,dBuyEmail,dBuyAttached,dPayState,dPaySerialCode,Status,AppendTime,UpdateTime';
				
				if(!$data->order){
					$data->order = 'UpdateTime desc';
				}
				
				$rb = $exp->geTableData($this->tbDBTradeLogInfo, parent::getListPage($data->page), parent::getListPageSize($data->pagesize), $data->condition, $data->order, $field);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	
	/**
	 * D币总额
	 */
	public function GetDBTotal ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
				
				if (!isset($data->user_id)) {
					return $this->_return ( false, 'user_id is missing' );
				}
	
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
				
				$UserID = $dbLogin->getUserID($data->user_id);
				
				if ( $UserID == 0 ) {
					$total = 0;
				} else {
					$total = $dbCoinDB->getCoinDBValueByUserID($UserID);
				}
				
				return $this->_return ( true, 'OK', $total );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 充值D币
	 */
	public function GetDBRecharge ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				if ( !isset($data->user_id) ) {
					return $this->_return ( false, 'user_id is missing' );
				}
	
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
	
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
	
				//双方用户对应平台ID
				$UserID    = $dbLogin->getUserID($data->user_id);
	
				unset($tArr);
				$tArr['UserID'] = $UserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 1; //充值
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 折现D币
	 */
	public function GetDBEnchash ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				if ( !isset($data->user_id) ) {
					return $this->_return ( false, 'user_id is missing' );
				}
	
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
	
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
	
				//双方用户对应平台ID
				$UserID    = $dbLogin->getUserID($data->user_id);
	
				unset($tArr);
				$tArr['UserID'] = $UserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 2; //折现
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 挣取D币
	 */
	public function GetDBEarn ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				if ( !isset($data->user_id) ) {
					return $this->_return ( false, 'user_id is missing' );
				}
	
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
	
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
	
				//双方用户对应平台ID
				$UserID    = $dbLogin->getUserID($data->user_id);
	
				unset($tArr);
				$tArr['UserID'] = $UserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 3; //挣取
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 消耗D币
	 */
	public function GetDBConsume ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				if ( !isset($data->user_id) ) {
					return $this->_return ( false, 'user_id is missing' );
				}
	
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
	
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
	
				//双方用户对应平台ID
				$UserID    = $dbLogin->getUserID($data->user_id);
	
				unset($tArr);
				$tArr['UserID'] = $UserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 4; //消耗
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
	
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 应用消耗D币，用户挣取D币
	 */
	public function GetDBAppWithUser ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
	
				if ( !isset($data->app_user_id) ) {
					return $this->_return ( false, 'app_user_id is missing' );
				}
				
				if ( !isset($data->user_id) ) {
					return $this->_return ( false, 'user_id is missing' );
				}
				
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
				
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
				
				//双方用户对应平台ID
				$appUserID = $dbLogin->getUserID($data->app_user_id);
				$UserID    = $dbLogin->getUserID($data->user_id);
				
				//验证当前消费用户是否有足够的数额
				$total = $dbCoinDB->getCoinDBValueByUserID($appUserID);
				if((intval($total)-intval($db)) < 0){
					return $this->_return ( false, 'The total of DB less than db' );
				}
				
				unset($tArr);
				//App应用消费
				$tArr['UserID'] = $appUserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 4; //消耗
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
		
				unset($tArr);
				//用户挣取
				$tArr['UserID'] = $UserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 3; //挣取
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
				
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
	
	/**
	 * 应用挣取D币，广告主消费D币
	 */
	public function GetDBAppWithAD ( $pa ) {
		if($this->authorized){
			$rb = null;
			if (isset($pa)) {
				$data = $this->_value ( json_decode ( $pa->data )->data );
				
				if ( !isset($data->app_user_id) ) {
					return $this->_return ( false, 'app_user_id is missing' );
				}
				
				if ( !isset($data->ad_user_id) ) {
					return $this->_return ( false, 'ad_user_id is missing' );
				}
				
				$db = $data->db;
				if ( $db < 0 ) {
					return $this->_return ( false, 'db must greater than zero' );
				}
				
				$this->_connect(); //加载数据库
				$dbLogin = parent::getClass($this->_getConnect, 'DB_Login');
				$dbCoinDB = parent::getClass($this->_getConnect, 'DB_CoinDB');
				
				//双方用户对应平台ID
				$appUserID = $dbLogin->getUserID($data->app_user_id);
				$adUserID  = $dbLogin->getUserID($data->ad_user_id);
				
				//验证当前消费用户是否有足够的数额
				$total = $dbCoinDB->getCoinDBValueByUserID($adUserID);
				if((intval($total)-intval($db)) < 0){
					return $this->_return ( false, 'The total of DB less than db' );
				}
				
				unset($tArr);
				//App应用挣取
				$tArr['UserID'] = $appUserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 3; //挣取
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
				
				unset($tArr);
				//广告主消费
				$tArr['UserID'] = $adUserID;
				$tArr['dState'] = $data->message;
				$tArr['CoinDB'] = $db;
				$tArr['dType']  = 4; //消耗
				$dbCoinDB->addCoinDBInfoByUserID($tArr);
				
				return $this->_return ( true, 'OK', $rb );
			}else{
				return $this->_return ( false, 'Data Error', $rb );
			}
		}else{
			return parent::Unauthorized_User();
		}
	}
}
?>