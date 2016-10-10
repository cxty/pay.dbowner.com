<?php
/**
 * DB登陆处理
 *
 * @author wbqing405@sina.com
 */
class DB_Login{
	
	var $tbUserInfo = 'tbUserInfo'; //用户表
	
	public function __construct($model){
		$this->model = $model;
	}
	/**
	 * 增加用户信息
	 */
	public function addUserInfo($fieldArr){
		try{
			$data['user_id']      = $fieldArr['user_id'];
			$data['uName']        = $fieldArr['uName'];
			$data['uType']        = 1;
			$data['Status']       = 0;
			$data['AppendTime']   = time();
			$data['UpdateTime']   = time();
			//ComFun::pr($data);exit;
			return $this->model->table($this->tbUserInfo)->data($data)->insert();
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 更新用户名
	 */
	public function updateUserNameByUserID($fieldArr){
		try{
			$condition['user_id'] = $fieldArr['user_id'];
				
			$data['uName'] = $fieldArr['uName'];
				
			$this->model->table($this->tbUserInfo)->data($data)->where($condition)->update();
				
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	/**
	 * 取用户信息
	 */
	public function checkUserInfoByUserID($user_id){
		try{
			$condition['user_id'] = $user_id;
			$condition['Status']  = 0;
			
			$field = 'AutoID,user_id,uName,uType';
			
			$re = $this->model->table($this->tbUserInfo)->field($field)->where($condition)->select();
			
			if($re){
				return $re[0];
			}else{
				return null;
			}
		}catch(Exception $e){
			return null;
		}
	}
	/**
	 * 通过user_id取用户UserID
	 */
	public function getUserID($user_id){
		try{
			$condition['user_id'] = $user_id;
			
			$_re = $this->model->table($this->tbUserInfo)->field('AutoID')->where($condition)->select();
			
			if($_re){
				return $_re[0]['AutoID'];
			}else{
				return 0;
			}
		}catch(Exception $e){
			return 0;
		}
	}
}