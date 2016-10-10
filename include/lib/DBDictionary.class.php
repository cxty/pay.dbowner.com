<?php
/**
 * 字典信息处理
 *
 * @author wbqing405@sina.com
 */
class DBDictionary{
	/**
	 * 返回城市信息
	 */
	public function getIPInfo(){
		$ip = ComFun::getIP();
		$ip = '218.104.232.181';
		$url = 'http://api.map.baidu.com/location/ip';
		$tArr['ak']   = $GLOBALS['config']['DB']['Baidu']['ak'];
		$tArr['ip']   = $ip;
		$tArr['coor'] = 'bd09ll'; //经纬度类型
		return DBCurl::dbGet($url, 'GET', $tArr);
	}
	/**
	 * 返回json文件
	 */
	public function getJsonFile($fileName){
		$file = dirname(dirname(dirname(__FILE__))).'/conf/json/'.$fileName.'.json';
		if(file_exists($file)){
			return json_decode(file_get_contents($file), true);
		}else{
			return '';
		}
	}
	/**
	 * 返回配置文件信息
	 */
	public static function getDictionary($fileName){
		$file = dirname(dirname(dirname(__FILE__))).'/conf/dictionary/'.$fileName.'.php';
		if(file_exists($file)){
			return include($file);
		}else{
			return '';
		}
	}
	/**
	 * 取配置文件
	 */
	public static function getDictSelect($fileName, $selectName='', $value=0, $hide=',-1,'){
		$list = self::getDictionary($fileName);
		
		$selectName = ($selectName == '') ? $fileName : $selectName;
		
		$html = '<select name="'.$selectName.'" id="'.$selectName.'">';
		if(is_array($list)){
			foreach($list as $key=>$val){
				if(strpos(','.$key.',',$hide) === false){
					if(intval($value) == $key){
						$html .= '<option value="'.$key.'" selected>'.$val.'</option>';
					}else{
						$html .= '<option value="'.$key.'">'.$val.'</option>';
					}
				}
			}
		}
		$html .= '</select>';
		
		return $html;
	}
	/**
	 * 取配置文件
	 */
	public static function getDictSelectAsort($fileName, $selectName='', $value=0, $hide=',-1,'){
		$list = self::getDictionary($fileName);
	
		$selectName = ($selectName == '') ? $fileName : $selectName;
	
		$html = '<select name="'.$selectName.'" id="'.$selectName.'">';
		if(is_array($list)){
			
			asort($list);
			
			foreach($list as $key=>$val){
				if(strpos(','.$key.',',$hide) === false){
					if(intval($value) == $key){
						$html .= '<option value="'.$key.'" selected>'.$val.'</option>';
					}else{
						$html .= '<option value="'.$key.'">'.$val.'</option>';
					}
				}
			}
		}
		$html .= '</select>';
	
		return $html;
	}
	/**
	 * 获取配置文件信息
	 */
	public function getDictionaryValue($fileName,$value){
		$list = self::getDictionary($fileName);

		if($list){
			foreach($list as $key=>$val){
				if(intval($value) == $key){
					return $val;
				}
			}
		}
	}
}