<?php
/**
 * DB正则匹配
 *
 * @author wbqing405@sina.com
 */
class DBReg{
	/**
	 * 验证是否是手机号
	 */
	public static function _isMobile($value){
		if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $value)){
			return true;	
		}else{
			return false;
		}
	}
	/**
	 * 验证是否是纯数字
	 */
	public static function _isPureNumber($value){
		if(preg_match("/^[0-9]+$/", $value)){
			return true;
		}else{
			return false;
		}
	}
}