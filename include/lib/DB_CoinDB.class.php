<?php
/**
 * D币交易处理
 *
 * @author wbqing405@sina.com
 */
class DB_CoinDB{
	
	var $tbDBTradeInfo = 'tbDBTradeInfo'; //D币交易信息表
	var $tbDBTradeLogInfo = 'tbDBTradeLogInfo'; //D币交易记录表
	var $tbDBTradeMonthInfo = 'tbDBTradeMonthInfo'; //D币交易月记录信息表
	var $tbAccountBaseInfo = 'tbAccountBaseInfo'; //财务信息表
	
	public function __construct( $model='' ){
		if ( isset($GLOBALS['model']) ) {
			$this->model = $GLOBALS['model'];
		} else {
			$this->model = $model;
		}
	}
	/**
	 * 创建随机码,不成功则不允许插入操作
	 */
	private function generateRandom($fieldArr){
		try{
			$tArr['UserID']      = $fieldArr['UserID'];
			$tArr['serialCode']  = $fieldArr['dSerialCode'];
			$tArr['coin']        = $fieldArr['CoinDB'];
			$tArr['type']        = $fieldArr['dType'];
			$tArr['AppendTime']  = $fieldArr['AppendTime'];

			$_re = DBCurl::dbGet($GLOBALS['config']['PLATFORM']['Secret'].'/authcode/getCoinRandomCode', 'get', $tArr);

			if($_re['state']){
				return $_re['msg'];
			}else{
				return '';
			}
		}catch(Exception $e){
			return '';
		}
	}
	/**
	 * 增加
	 */
	public function addCoinDBInfo($fieldArr){
		$fieldArr['UserID']      = ComFun::getCookies('UserID');
		$fieldArr['dSerialCode'] = $fieldArr['dSerialCode'];
		$fieldArr['AppendTime']  = time();
		$fieldArr['dRandomCode'] = $this->generateRandom($fieldArr);
		if(!$fieldArr['dSerialCode']){
			return false;
		}
		
		mysql_query("BEGIN");
		
		if($this->_addCoinDBTrade($fieldArr) && $this->_addCoinDBTradeLog($fieldArr) && $this->_addCoinDBTradeMonth($fieldArr)){
			mysql_query("COMMIT");
			$_rb = true;
		}else{
			mysql_query("ROLLBACK");
			$_rb = false;
		}
			
		mysql_query("END");	
		
		return $_rb;
	}
	/**
	 * 通过UserID增加记录
	 */
	public function addCoinDBInfoByUserID($fieldArr){
		$fieldArr['dSerialCode'] = ComFun::getSerialCode();
		$fieldArr['AppendTime']  = time();
		$fieldArr['dRandomCode'] = $this->generateRandom($fieldArr);
		if(!$fieldArr['dSerialCode']){
			return false;
		}
	
		mysql_query("BEGIN");
	
		if($this->_addCoinDBTrade($fieldArr) && $this->_addCoinDBTradeLog($fieldArr) && $this->_addCoinDBTradeMonth($fieldArr)){
			mysql_query("COMMIT");
			$_rb = true;
		}else{
			mysql_query("ROLLBACK");
			$_rb = false;
		}
			
		mysql_query("END");
	
		return $_rb;
	}
	/**
	 * 添加现金交易信息表
	 */
	private function _addCoinDBTrade($fieldArr){
		try{		
			$condition['UserID'] = $fieldArr['UserID'];
			
			$_re = $this->model->table($this->tbDBTradeInfo)->field('AutoID,CoinDB')->where($condition)->select();
			
			if($fieldArr['dType'] == 1 || $fieldArr['dType'] == 3){
				$CoinDB = $fieldArr['CoinDB'];
			}else{
				$CoinDB = -$fieldArr['CoinDB'];
			}
			
			if($_re){
				$data['CoinDB']     = $CoinDB + $_re[0]['CoinDB'];
				$data['UpdateTime'] = time();
				
				$this->model->table($this->tbDBTradeInfo)->data($data)->where($condition)->update();
				
				$_rb = $_re[0]['AutoID'];
			}else{
				$data['UserID']     = $fieldArr['UserID'];
				$data['CoinDB']     = $CoinDB;
				$data['Status']     = 0;
				$data['AppendTime'] = $fieldArr['AppendTime'];
				$data['UpdateTime'] = time();
				
				$_rb = $this->model->table($this->tbDBTradeInfo)->data($data)->insert();
			}
			
			return $_rb;
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 添加现金交易记录表
	 */
	private function _addCoinDBTradeLog($fieldArr){
		try{
			$data['UserID']       = $fieldArr['UserID'];
			$data['dSerialCode']  = $fieldArr['dSerialCode'];
			$data['dState']       = $fieldArr['dState'];
			$data['CoinDB']       = $fieldArr['CoinDB'];
			$data['dType']        = $fieldArr['dType'] ? $fieldArr['dType'] : 2;
			$data['dRandomCode']  = $fieldArr['dRandomCode'];
			$data['dBuyPlatform'] = $fieldArr['dBuyPlatform'];
			$data['dBuyEmail']    = $fieldArr['dBuyEmail'];
			$data['dBuyAttached'] = $fieldArr['dBuyAttached'];
			$data['Status']       = 0;
			$data['AppendTime']   = $fieldArr['AppendTime'];
			$data['UpdateTime']   = time();
			
			return $this->model->table($this->tbDBTradeLogInfo)->data($data)->insert();
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 现金交易月记录信息表
	 */
	private function _addCoinDBTradeMonth($fieldArr){
		try{
			$condition['UserID'] = $fieldArr['UserID'];
			$condition['dYear']  = date('Y');
			$condition['dMonth'] = date('m');
			
			$_re = $this->model->table($this->tbDBTradeMonthInfo)->field('AutoID,CoinDB')->where($condition)->select();
		
			if($fieldArr['dType'] == 1 || $fieldArr['dType'] == 3){
				$CoinDB = $fieldArr['CoinDB'];
			}else{
				$CoinDB = -$fieldArr['CoinDB'];
			}
			
			if($_re){
				$data['CoinDB']     = $CoinDB + $_re[0]['CoinDB'];
				$data['AppendTime'] = time();
				
				$this->model->table($this->tbDBTradeMonthInfo)->data($data)->where($condition)->update();
			
				$_rb = $_re[0]['AutoID'];
			}else{
				$data['UserID']     = $fieldArr['UserID'];
				$data['CoinDB']     = $CoinDB;
				$data['dYear']      = date('Y');
				$data['dMonth']     = date('m');
				$data['Status']     = 0;
				$data['AppendTime'] = $fieldArr['AppendTime'];
				$data['UpdateTime'] = time();
				
				$_rb = $this->model->table($this->tbDBTradeMonthInfo)->data($data)->insert();
			}
			
			return $_rb;
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 取现金余额
	 */
	public function getCoinDBValue(){
		try{
			$condition['UserID'] = ComFun::getCookies('UserID');
			
			$_re = $this->model->table($this->tbDBTradeInfo)->field('CoinDB')->where($condition)->select();
			
			if($_re){
				return $_re[0]['CoinDB'];
			}else{
				return 0;
			}
		}catch(Exception $e){
			return 0;
		}
	}
	/**
	 * 取指定用户现金余额
	 */
	public function getCoinDBValueByUserID($UserID){
		try{
			$condition['UserID'] = $UserID;
	
			$_re = $this->model->table($this->tbDBTradeInfo)->field('CoinDB')->where($condition)->select();
			
			if($_re){
				return $_re[0]['CoinDB'];
			}else{
				return 0;
			}
		}catch(Exception $e){
			return ComFun::_rw_sprintf(0);
		}
	}
	/**
	 * 取交易记录列表
	 */
	public function getCoinDBList($fieldArr='', $pagesize=10, $page=1){
		try{
			$page = $page ? $page : 1;
			$limit = (($page - 1) * $pagesize) . ',' . $pagesize;
	
			$order = 'UpdateTime desc';

			$where = '  UserID = \''.ComFun::getCookies('UserID').'\'';
			if( isset($fieldArr['Status']) ){
				$where .= ' and Status in ('.$fieldArr['Status'].')';
			}
			if($fieldArr['startTime']){
				$where .= ' and AppendTime >= \''.strtotime($fieldArr['startTime']).'\'';
			}
			if($fieldArr['endTime']){
				$where .= ' and AppendTime <= \''.strtotime($fieldArr['endTime']).'\'';
			}
			if($fieldArr['tradeType']){
				if($fieldArr['tradeType'] == 1){
					$where .= ' and dType in (1,3)';
				}else{
					$where .= ' and dType in (2,4)';
				}
			}
			if($fieldArr['dType']){
				$where .= ' and dType = \''.$fieldArr['dType'].'\'';
			}
	
			$field = 'dSerialCode,dState,CoinDB,dType,Status,AppendTime';	
			// 获取行数
			$count = $this->model->table($this->tbDBTradeLogInfo)->field('AutoID')->where($where)->count();		
			$list = $this->model->table($this->tbDBTradeLogInfo)->field($field)->where($where)->order($order)->limit($limit)->select();
			
			return array (
					'count' => $count,
					'list' => $list
			);
		}catch(Exception $e){
			return array (
					'count' => 0,
					'list' => null
			);
		}
	}
	/**
	 * 取待转账的记录,$id为UserID
	 */
	public function getWaitWithdraw($id){
		try{
			$where = ' a.UserID in ( ' . $id . ' ) and b.Status != 1 and b.dType = 2 ';
			$field = ' a.UserID,a.aType,a.aUserName,a.aAccountNumber,b.dSerialCode,b.CoinDB ';
			$sql = 'select ' . $field . ' from ' . $this->tbAccountBaseInfo . ' as a left join ' . $this->tbDBTradeLogInfo . ' as b on a.UserID = b.UserID 
where ' . $where . ' order by b.AppendTime asc';

			return $this->model->query($sql);
		}catch(Exception $e){
			return '';
		}
	}
	/**
	 * 取待转账的记录,$id为tbDBTradeLogInfo表AutoID
	 */
	public function getWaitWithdrawByID( $id ){
		try{
			if( $id ){
				$where = ' b.AutoID in ( ' . $id . ' ) and b.Status != 1 and b.dType = 2 ';
				$field = ' a.UserID,a.aType,a.aUserName,a.aAccountNumber,b.dSerialCode,b.CoinDB ';
				$sql = 'select ' . $field . ' from ' . $this->tbAccountBaseInfo . ' as a left join ' . $this->tbDBTradeLogInfo . ' as b on a.UserID = b.UserID
				where ' . $where . ' order by b.AppendTime asc';
					
				return $this->model->query($sql);
			}else{
				return '';
			}			
		}catch(Exception $e){
			return '';
		}
	}
	/**
	 * 转账开始时，更新其状态为'正在转账'
	 */
	public function updateWithdrawingByID( $id ){
		try{
			if( $id ){
				$where = ' AutoID in ( ' . $id . ' ) and Status != 1 and dType = 2 ';
					
				$data['Status'] = 3;
				
				$this->model->table($this->tbDBTradeLogInfo)->data($data)->where($where)->update();
					
				return true;
			}else{
				return false;
			}
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 转账成功后返回的状态处理
	 */
	public function changeWithdraw($fieldArr){
		try{
			$condition['dSerialCode'] = $fieldArr['dSerialCode'];
			
			$data['Status']         = $fieldArr['Status'];
			$data['dPayState']      = $fieldArr['dPayState'];
			$data['dPaySerialCode'] = $fieldArr['dPaySerialCode'];
			$data['UpdateTime']     = time();
			
			$this->model->table($this->tbDBTradeLogInfo)->data($data)->where($condition)->update();
			
			return true;
		}catch(Exception $e){
			return false;
		}
	}
}