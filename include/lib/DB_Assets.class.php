<?php
/**
 * 现金交易处理
 *
 * @author wbqing405@sina.com
 */
class DB_Assets{
	
	var $tbAssetsTradeInfo = 'tbAssetsTradeInfo'; //现金交易信息表
	var $tbAssetsTradeLogInfo = 'tbAssetsTradeLogInfo'; //现金交易记录表
	var $tbAssetsTradeMonthInfo = 'tbAssetsTradeMonthInfo'; //现金交易月记录信息表
	var $tbWithdrowLogInfo = 'tbWithdrowLogInfo'; //提现记录表
	
	public function __construct(){
		$this->model = $GLOBALS['model'];
	}
	/**
	 * 创建随机码,不成功则不允许插入操作
	 */
	private function generateRandom($fieldArr){	
		try{
			$tArr['UserID']      = $fieldArr['UserID'];
			$tArr['serialCode']  = $fieldArr['cSerialCode'];
			$tArr['coin']        = $fieldArr['Assets'];
			$tArr['type']        = $fieldArr['cType'];
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
	public function addAssetsInfo($fieldArr){
		$fieldArr['UserID']      = ComFun::getCookies('UserID');
		//$fieldArr['cSerialCode'] = ComFun::getSerialCode(); 
		$fieldArr['AppendTime']  = time();
		$fieldArr['cRandomCode'] = $this->generateRandom($fieldArr);
		if(!$fieldArr['cSerialCode']){
			return false;
		}
		
		mysql_query("BEGIN");
		
		if($this->_addAssetsTrade($fieldArr) && $this->_addAssetsTradeLog($fieldArr) && $this->_addAssetsTradeMonth($fieldArr)){
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
	private function _addAssetsTrade($fieldArr){
		try{		
			$condition['UserID'] = $fieldArr['UserID'];
			
			$_re = $this->model->table($this->tbAssetsTradeInfo)->field('AutoID,Assets')->where($condition)->select();
			
			if($fieldArr['cType'] == 1 || $fieldArr['cType'] == 3){
				$Assets = ComFun::_rw_sprintf($fieldArr['Assets']);
			}else{
				$Assets = -ComFun::_rw_sprintf($fieldArr['Assets']);
			}
			
			if($_re){
				$data['Assets']     = $Assets + $_re[0]['Assets'];
				$data['UpdateTime'] = time();
				
				$this->model->table($this->tbAssetsTradeInfo)->data($data)->where($condition)->update();
				
				$_rb = $_re[0]['AutoID'];
			}else{
				$data['UserID']     = $fieldArr['UserID'];
				$data['Assets']     = $Assets;
				$data['Status']     = 0;
				$data['AppendTime'] = $fieldArr['AppendTime'];
				$data['UpdateTime'] = time();
				
				$_rb = $this->model->table($this->tbAssetsTradeInfo)->data($data)->insert();
			}
			
			return $_rb;
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 添加现金交易记录表
	 */
	private function _addAssetsTradeLog($fieldArr){
		try{
			$data['UserID']       = $fieldArr['UserID'];
			$data['cSerialCode']  = $fieldArr['cSerialCode'];
			$data['cState']       = $fieldArr['cState'];
			$data['Assets']       = ComFun::_rw_sprintf($fieldArr['Assets']);
			$data['cType']        = $fieldArr['cType'] ? $fieldArr['cType'] : 2;
			$data['cBuyPlatform'] = $fieldArr['cBuyPlatform'];
			$data['cBuyEmail']    = $fieldArr['cBuyEmail'];
			$data['cBuyAttached'] = $fieldArr['cBuyAttached'];
			$data['cRandomCode']  = $fieldArr['cRandomCode'];
			$data['Status']       = 0;
			$data['AppendTime']   = $fieldArr['AppendTime'];
			$data['UpdateTime']   = time();
				
			return $this->model->table($this->tbAssetsTradeLogInfo)->data($data)->insert();
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 现金交易月记录信息表
	 */
	private function _addAssetsTradeMonth($fieldArr){
		try{
			$condition['UserID'] = $fieldArr['UserID'];
			$condition['cYear']  = date('Y');
			$condition['cMonth'] = date('m');
			
			$_re = $this->model->table($this->tbAssetsTradeMonthInfo)->field('AutoID,Assets')->where($condition)->select();
		
			if($fieldArr['cType'] == 1 || $fieldArr['cType'] == 3){
				$Assets = ComFun::_rw_sprintf($fieldArr['Assets']);
			}else{
				$Assets = -ComFun::_rw_sprintf($fieldArr['Assets']);
			}
			
			if($_re){
				$data['Assets']     = $Assets + $_re[0]['Assets'];
				$data['AppendTime'] = time();
				
				$this->model->table($this->tbAssetsTradeMonthInfo)->data($data)->where($condition)->update();
			
				$_rb = $_re[0]['AutoID'];
			}else{
				$data['UserID']     = $fieldArr['UserID'];
				$data['Assets']     = $Assets;
				$data['cYear']      = date('Y');
				$data['cMonth']     = date('m');
				$data['Status']     = 0;
				$data['AppendTime'] = $fieldArr['AppendTime'];
				$data['UpdateTime'] = time();
				
				$_rb = $this->model->table($this->tbAssetsTradeMonthInfo)->data($data)->insert();
			}
			
			return $_rb;
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 取现金余额
	 */
	public function getAssetsValue(){
		try{
			$condition['UserID'] = ComFun::getCookies('UserID');
			
			$_re = $this->model->table($this->tbAssetsTradeInfo)->field('Assets')->where($condition)->select();
			
			if($_re){
				return ComFun::_rw_sprintf($_re[0]['Assets']);
			}else{
				return ComFun::_rw_sprintf(0);
			}
		}catch(Exception $e){
			return ComFun::_rw_sprintf(0);
		}
	}
	/**
	 * 取交易记录列表
	 */
	public function getAssetsList($fieldArr='', $pagesize=10, $page=1){
		try{
			$page = $page ? $page : 1;
			$limit = (($page - 1) * $pagesize) . ',' . $pagesize;
	
			$order = 'UpdateTime desc';
	
			$where = 'Status = 0 and UserID = \''.ComFun::getCookies('UserID').'\'';
			if($fieldArr['startTime']){
				$where .= ' and AppendTime >= \''.strtotime($fieldArr['startTime']).'\'';
			}
			if($fieldArr['endTime']){
				$where .= ' and AppendTime <= \''.strtotime($fieldArr['endTime']).'\'';
			}
			if($fieldArr['tradeType']){
				if($fieldArr['tradeType'] == 1){
					$where .= ' and cType in (1,3)';
				}else{
					$where .= ' and cType in (2,4)';
				}
			}
	
			$field = 'cSerialCode,cState,Assets,cType,AppendTime';
			// 获取行数
			$count = $this->model->table($this->tbAssetsTradeLogInfo)->field('AutoID')->where($where)->count();
			$list = $this->model->table($this->tbAssetsTradeLogInfo)->field($field)->where($where)->order($order)->limit($limit)->select();
				
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
	 * 增加提现记录表
	 */
	public function addwithdrawInfo($fieldArr){
		try{
			$fieldArr['UserID']      = ComFun::getCookies('UserID');
			$fieldArr['AppendTime']  = time();
			$fieldArr['cRandomCode'] = $this->generateRandom($fieldArr);
			if(!$fieldArr['cSerialCode']){
				return false;
			}
				
			$data['UserID']       = $fieldArr['UserID'];
			$data['cSerialCode']  = $fieldArr['cSerialCode'];
			$data['cState']       = $fieldArr['cState'];
			$data['Assets']       = ComFun::_rw_sprintf($fieldArr['Assets']);
			$data['cType']        = $fieldArr['cType'] ? $fieldArr['cType'] : 2;
			$data['cRandomCode']  = $fieldArr['cRandomCode'];
			$data['Status']       = 2;
			$data['AppendTime']   = $fieldArr['AppendTime'];
			$data['UpdateTime']   = time();

			return $this->model->table($this->tbWithdrowLogInfo)->data($data)->insert();
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 取交易记录列表
	 */
	public function getwithdrawList($fieldArr='', $pagesize=10, $page=1){
		try{
			$page = $page ? $page : 1;
			$limit = (($page - 1) * $pagesize) . ',' . $pagesize;
	
			$order = 'UpdateTime desc';
	
			$where = ' UserID = \''.ComFun::getCookies('UserID').'\'';
			if($fieldArr['startTime']){
				$where .= ' and AppendTime >= \''.strtotime($fieldArr['startTime']).'\'';
			}
			if($fieldArr['endTime']){
				$where .= ' and AppendTime <= \''.strtotime($fieldArr['endTime']).'\'';
			}
			if($fieldArr['tradeType']){
				$where .= ' and Status = \''.$fieldArr['tradeType'].'\'';
			}
	
			$field = 'cSerialCode,cState,Assets,cType,Status,AppendTime';
			// 获取行数
			$count = $this->model->table($this->tbWithdrowLogInfo)->field('AutoID')->where($where)->count();
			$list = $this->model->table($this->tbWithdrowLogInfo)->field($field)->where($where)->order($order)->limit($limit)->select();
	
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
	 * 提现状态改变
	 * 成功则添加转账表并改变状态
	 * 失败则改变状态
	 */
	public function changeWithdraw($fieldArr){
		try{
			$condition['cSerialCode'] = $fieldArr['cSerialCode'];	
			
			if($fieldArr['cPayStatus'] == 1){	
				$re = $this->model->table($this->tbWithdrowLogInfo)->field('UserID,cSerialCode,cState,Assets,cType')->where($condition)->select();
				
				if($re){
					$this->addAssetsInfo($re[0]);
				}
			}
			
			$data['Status']         = 0;
			$data['cPayStatus']     = $fieldArr['cPayStatus'];
			$data['cPayState']      = $fieldArr['cPayState'];
			$data['cPaySerialCode'] = $fieldArr['cPaySerialCode'];
			$data['UpdateTime']     = time();
				
			$this->model->table($this->tbWithdrowLogInfo)->data($data)->where($condition)->update();
		}catch(Exception $e){
			return false;
		}
	}
}