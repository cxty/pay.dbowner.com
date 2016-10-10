<?php
/**
 * 财政信息
 *
 * @author wbqing405@sina.com
 */
class DB_AccountMsg{
	
	var $tbAccountBaseInfo = 'tbAccountBaseInfo';
	
	public function __construct(){
		$this->model = $GLOBALS['model'];
	}
	/**
	 * 增加
	 */
	public function addAccountBase( $fieldArr ){
		try{	
			$condition['UserID'] = $fieldArr['UserID'];
			
			if( $this->model->table($this->tbAccountBaseInfo)->field('AutoID')->where($condition)->select() ){
				return -2;
			}else{
				$data['UserID']         = $fieldArr['UserID'];
				$data['aType']          = $fieldArr['aType'];
				$data['aUserName']      = $fieldArr['aUserName'];
				$data['aAccountNumber'] = $fieldArr['aAccountNumber'];
				$data['Status']         = 0;
				$data['AppendTime']     = time();
				$data['UpdateTime']     = time();
					
				return $this->model->table($this->tbAccountBaseInfo)->data($data)->insert();
			}	
		}catch(Exception $e){
			return -1;
		}
	}
	/**
	 * 修改
	 */
	public function modifyAccountBase( $fieldArr ){
		try{
			$condition['AutoID'] = $fieldArr['AutoID'];
			
			$data['aType']          = $fieldArr['aType'];
			$data['aUserName']      = $fieldArr['aUserName'];
			$data['aAccountNumber'] = $fieldArr['aAccountNumber'];

			$this->model->table($this->tbAccountBaseInfo)->data($data)->where($condition)->update();
			
			return 1;	
		}catch(Exception $e){
			return -1;
		}
	}
	/**
	 * 查询当前信息
	 */
	public function getAccountBaseInfoByUserID( $UserID ){
		try{
			$condition['UserID'] = $UserID;

			$re = $this->model->table($this->tbAccountBaseInfo)->field('AutoID,aType,aUserName,aAccountNumber')->where($condition)->select();
			
			if($re){
				return $re[0];
			}else{
				return '';
			}
		}catch(Exception $e){
			return '';
		}
	}
}