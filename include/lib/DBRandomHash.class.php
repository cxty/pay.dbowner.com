<?php
/**
 * 
 * 
 * @author wbqing405@sina.com
 */
class DBRandomHash{	
	/**
	 * 重新生成文件时间间隔
	 */
	private static $_pass_day = 5; 
	/**
	 * 取加密字符串位数
	 */
	private static $_random_num = 10;
	/**
	 * 文件的位置
	 */
	private static function _basepath(){
		return (dirname(dirname(dirname(__FILE__)))); //生成文件位置
	}
	/**
	 * 载入加密文件
	 */
	private static function _load_des($key, $iv=0){
		if($GLOBALS['DES_DBRandomHash']){
			return $GLOBALS['DES_DBRandomHash'];
		}else{
			require_once dirname(__FILE__).'/DES.class.php';	
			$GLOBALS['DES_DBRandomHash'] = new DES($key, $iv);
			
			return $GLOBALS['DES_DBRandomHash'];
		}
	}
	/**
	 * 取加密字符串
	 * $code：截取字符串
	 * $string 要加密的字符串
	 */
	public static function encryptRandomString($code,$string){
		if(strlen($code) <= 2) return '';
		if(!preg_match("/^\d*$/",   $code)) return '';
		if(empty($string)) return '';
		
		$_ra = self::getRandomHash();
		
		$des = self::_load_des($_ra[substr($code, -1, 1)], $_ra[substr($code, -2, 1)]);

		return self::urlencode_rfc3986(base64_encode($des->encrypt($string)));
	}
	/**
	 * 取解密字符串
	 * $code：截取字符串
	 * $string 要加密的字符串
	 */
	public static function decryptRandomString($code,$string){
		if(strlen($code) <= 2) return '';
		if(!preg_match("/^\d*$/",   $code)) return '';
		if(empty($string)) return '';
	
		$_ra = self::getRandomHash();

		$des = self::_load_des($_ra[substr($code, -1, 1)], $_ra[substr($code, -2, 1)]);
				
		try{
			return $des->decrypt(base64_decode($string));
		}catch(Exception $e){
			return '';
		}
	}
	/**
	 * urlencode处理
	 */
	private static function urlencode_rfc3986($input) {
		if (is_scalar($input)) {
			return str_replace(
					'+',
					' ',
					str_replace('%7E', '~', rawurlencode($input))
			);
		} else {
			return '';
		}
	}
	/**
	 * 取加密文件
	 */
	public static function getRandomHash(){
		$basepath = self::_basepath().'/conf/pwd/'.date('Y');
	
		//目录是否存在，不存在，则创建
		if(!is_dir($basepath)){
			@mkdir($basepath, 0777);
		}
	
		//目录是否可写，不可写，则修改属性
		if(!is_writable($basepath)){
			@chmod($basepath,0777);
		}
	
		$filepath = $basepath.'/'.md5('randomPassword'.date('Ymd')).'.php';

		if(!is_file($filepath)){
			self::_writeRandomContent($filepath);
		}else{
			if(intval((time()-filemtime($filepath))/86400) > self::$_pass_day){
				self::_writeRandomContent($filepath);
			}
		}
	
		return require($filepath);
	}
	/**
	 * 写密码文件内容
	 */
	private static function _writeRandomContent($filepath){
		for($i=0;$i<10;$i++){
			$rdArr[$i] = self::_getRandom(self::$_random_num);
		}
	
		file_put_contents($filepath, '<?php return '.var_export($rdArr, true) . '; ?>', LOCK_EX);
	}
	/**
	 * 随机码
	 */
	private static function _getRandom($len=10,$start=2,$end=16){
		$srcstr="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
		mt_srand();
		$strs="";
	
		for($i=0;$i<$len;$i++){
			$strs.=$srcstr[mt_rand(0,35)];
		}
	
		$strs .= time();
	
		return substr(md5($strs),$start,$end);
	}
}