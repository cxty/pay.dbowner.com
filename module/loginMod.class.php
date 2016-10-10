<?php
/**
 *
 * 登录页面
 *
 * @author wbqing405@sina.com
 *
 */
class loginMod extends commonMod{
	/**
	 * 授权登录第一步
	 */
	public function login(){
		$url = $this->commonOAuth2->getAuthorizeOAuth();
	
		//后台用户登录
		$cookies['dbo'] = $_GET['dbo'];
		$ident = $_GET['ident'];
		if($ident){
			ComFun::saveCallBack($_GET);
			$cookies['ident'] = $ident;
		}
		ComFun::SetCookies($cookies);
		
		$this->redirect($url);
	}
	/**
	 * 授权登录第二步
	 */
	public function callback(){
		if(isset($_GET['access_token'])){
			$token['access_token']  = $_GET['access_token'];
			$token['refresh_token'] = $_GET['refresh_token'];
			$token['user_id']       = $_GET['user_id'];
		}else{
			$token = $this->commonOAuth2->getAccessOAuth();
		}
		
		ComFun::SetCookies($token);
	
		$this->redirect('/login/setLoginInfo');
	}
	/**
	 * 保存登录信息
	 */
	public function setLoginInfo(){	
		//取用户信息
		$userInfo = $this->commonOAuth2->getUserInfo();	
		
		if(!$userInfo){
			$this->redirect('/throwMessage/throwMsg?tt=2&msgkey=TWSystemError9001');
		}	
		
		$user_id = $userInfo['id'];
			
		$cookies['user_id'] = $user_id;
		$cookies['uName']   = $userInfo['name'];
		$cookies['group']   = $userInfo['group'];
		$cookies['account'] = $userInfo['account'];
		$cookies['ico']     = $userInfo['ico']['m'];
			
		$dbLogin = $this->getClass('DB_Login');
		$userList = $dbLogin->checkUserInfoByUserID($user_id);
			
		if ( count($userList) > 0 ){
			$dbLogin->updateUserNameByUserID($cookies);
		} else {
			$UserID = $dbLogin->addUserInfo($cookies);
		}
			
		$cookies['UserID']   = $userList['AutoID'] ? $userList['AutoID'] : $UserID;
		$cookies['uType']    = $userList['uType'] ? $userList['uType'] : 1;
			
		$ident = ComFun::getCookies('ident');
			
		ComFun::SetCookies($cookies);
			
		//检验是否有回调地址,若无则调到后台页面
		$url = $_COOKIE['dbo'] ? ComFun::_decryptUrl(ComFun::getCookies('dbo')) : strtolower(__ROOT__);

		$dcookies['ident'] = $ident;
		ComFun::destoryCookies($dcookies);
	
		$this->redirect($url);
	}
	/**
	 * 退出
	 */
	public function loginOut(){
		ComFun::destoryCookies();
		
		$userInfo = $this->commonOAuth2->signout();
	}
	/**
	 * 检验用户是否过期
	 */
	public function checkLoginStatues(){
		//取用户登录状态
		$re =  $this->commonOAuth2->api_istimeout();
		if(!isset($re['id'])){
			echo true;
		}else{
			echo false;
		}
	}
}