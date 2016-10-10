<?php
include('conf.php');
//网站全局配置
$config['ver']									='1.0';

//网站全局配置结束

//日志和错误调试配置
$config['DEBUG']								=true;								//是否开启调试模式，true开启，false关闭
$config['LOG_ON']								=true;								//是否开启出错信息保存到文件，true开启，false不开启
$config['LOG_PATH']								='./data/log/';					//出错信息存放的目录，出错信息以天为单位存放
$config['ERROR_URL']							='';							//出错信息重定向页面，为空采用默认的出错页面
$config['ERROR_HANDLE']							=false;

//应用配置
		//网址配置
$config['URL_REWRITE_ON']						=true;						//是否开启重写，true开启重写,false关闭重写
$config['URL_MODULE_DEPR']						='/';						//模块分隔符
$config['URL_ACTION_DEPR']						='-';						//操作分隔符
$config['URL_PARAM_DEPR']						='-';						//参数分隔符
$config['URL_HTML_SUFFIX']						='.html';					//伪静态后缀设置，，例如 .html 
		
		//模块配置
$config['MODULE_PATH']							='./module/';					//模块存放目录
$config['MODULE_SUFFIX']						='Mod.class.php';			//模块后缀
$config['MODULE_INIT']							='init.php';					//初始程序
$config['MODULE_DEFAULT']						='index';					//默认模块
$config['MODULE_EMPTY']							='empty';					//空模块		
		
		//操作配置
$config['ACTION_DEFAULT']						='index';					//默认操作
$config['ACTION_EMPTY']							='_empty';					//空操作

		//静态页面缓存
$config['HTML_CACHE_ON']						=false;						//是否开启静态页面缓存，true开启.false关闭
$config['HTML_CACHE_PATH']						='./cache/html_cache/';	//静态页面缓存目录
$config['HTML_CACHE_SUFFIX']					='.html';				//静态页面缓存后缀
$config['HTML_CACHE_RULE']['index']['index']	=1000;	//缓存时间,单位：秒

//模板配置
$config['TPL_TEMPLATE_PATH']		='./templates/';			//模板目录
$config['TPL_TEMPLATE_SUFFIX']		='.html';					//模板后缀
$config['TPL_CACHE_ON']				=false;						//是否开启模板缓存，true开启,false不开启
$config['TPL_CACHE_PATH']			='./cache/tpl_cache/';		//模板缓存目录
$config['TPL_CACHE_SUFFIX']			='.php';					//模板缓存后缀,一般不需要修改

// smarty 配置
$config['SMARTY_DEBUGGING']         = false;              		//是否开启调试模式
$config['SMARTY_CACHING']           = FALSE;              		//是否开启缓存
$config['SMARTY_TEMPLATE_DIR']      = './templates/';      		//缓存时间
$config['SMARTY_CACHE_LIFETIME']    = 30;                 		//缓存时间
$config['SMARTY_COMPILE_DIR']       = './data/smarty/compile_dir'; //smarty模板编译文件存放的目录
$config['SMARTY_CACHE_DIR']         = './data/smarty/cache_dir';   //smarty模板缓存文件存放的目录
$config['SMARTY_LEFT_DELIMITER']    = '{';                         //左定界符
$config['SMARTY_RIGHT_DELIMITER']   = '}';                         //右定界符

//多语言配置 
$config['LANG_DEFAULT']				='zh-cn';       	//默认语言
$config['LANG_PACK_PATH']			='./lang/';      	//语言包目录
$config['LANG_PACK_SUFFIX']			='.lang.php';    	//语言包后缀 
$config['LANG_PACK_COMMON']			='common';   		//公用语言包，默认会自动加载

//邮件配置
$config['EMAIL']['url']            = 'http://192.168.0.252:8083/MailQueueService.asmx?WSDL';
$config['EMAIL']['UserName']       = 'Yannyo_Local_PassPort';
$config['EMAIL']['UserPWD']        = '1q2w3e@1q2w3e';
$config['EMAIL']['mSendMail']      = 'support@yannyo.com';
$config['EMAIL']['mIsHTML']        = true;
$config['EMAIL']['SetSendTime']    = strtotime(date('Y-m-d h:i:s',strtotime('1 minute')));

//DES加密配置
$config['DES']['SOAP_USER']				 ='soap_server';  //DES 用户名
$config['DES']['SOAP_PWD']				 ='soap_pwd';   //DES 密码
$config['DES']['SOAP_IV']				 ='12345678';   //DES 偏移量
$config['DES']['Soap_Client']	   		 ='http://dev.dbowner.com/soap/manage?wsdl';   //SoapClient地址
$config['DES']['Soap_Header']			 ='http://dev.dbowner.com';   //SoapHeader地址
$config['DES']['Soap_Client_Expand']	 ='http://expand.dbowner.com/soap/extendSoap?wsdl';
$config['DES']['Soap_Header_Expand']	 ='http://expand.dbowner.com/soap';   //SoapHeader地址
$config['DES']['Soap_Client_Auth']	     ='http://soap.auth.dbowner.com/soap/userInfoSoap?wsdl';
$config['DES']['Soap_Header_Auth']	     ='http://soap.auth.dbowner.com/soap';   //SoapHeader地址
$config['DES']['Soap_Client_User']	     ='http://user.dbowner.com/soap/userInfoSoap?wsdl';   //SoapClient地址
$config['DES']['Soap_Header_User']		 ='http://user.dbowner.com';   //SoapHeader地址
$config['DES']['Soap_Client_Plus']	     ='http://plus.dbowner.com/soap/plugInSoap?wsdl';
$config['DES']['Soap_Header_Plus']	     ='http://plus.dbowner.com/soap';   //SoapHeader地址
$config['DES']['Soap_Client_Pay']	     ='http://pay.dbowner.com/soap/paySoap?wsdl';
$config['DES']['Soap_Header_Pay']	     ='http://pay.dbowner.com/soap';   //SoapHeader地址
$config['DES']['Soap_Client_tPay']	     ='http://tpay.dbowner.com/soap/paySoap?wsdl';
$config['DES']['Soap_Header_tpay']	     ='http://tpay.dbowner.com/soap';   //SoapHeader地址

//汇率转化地址
$config['ExchangeRate_url']	= 'http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate';

//文件服务器
$config['FILE_SERVER_UP'] ='http://file.dbowner.com:80/index.php?act=up';  //保存文件
$config['FILE_SERVER_GET']='http://file.dbowner.com:80/index.php?act=get'; //读取文件

$config['DES']['SOAP_SERVER_CLIENTIP']	 = array('127.0.0.1','192.168.0.1','192.168.0.33','192.168.0.195','192.168.0.197');   //SoapHeader地址
$config['NoNeedLogin'] = array(
							'common','throwMessage','login','file','soap' //公用的
							,'callback' //私用的
					);

$config['PLATFORM']['Auth']       = 'http://auth.dbowner.com'; //用户中心
$config['PLATFORM']['Wiki']       = 'http://wiki.dbowner.com'; //DBOwner维基
$config['PLATFORM']['Expand']     = 'http://expand.dbowner.com';  //应用扩展平台
$config['PLATFORM']['Plus']       = 'http://plus.dbowner.com';  //插件平台
$config['PLATFORM']['Ad']         = 'http://ad.dbowner.com'; //广告联盟
$config['PLATFORM']['Union']      = 'http://union.dbowner.com'; //广告展示
$config['PLATFORM']['Pay']        = 'http://pay.dbowner.com'; //支付中心
$config['PLATFORM']['Analysis']   = 'http://analysis.dbowner.com'; //数据分析中心
$config['PLATFORM']['Datamarket'] = 'http://datamarket.dbowner.com'; //数据交易中心
$config['PLATFORM']['Dev']        = 'http://dev.dbowner.com'; //应用中心
$config['PLATFORM']['Secret']     = 'http://secret.dbowner.com'; //内部验证平台


$config['DB']['Pay']['ExchangeRate'] = 100; //现金转D币汇率
$config['DB']['Pay']['pwd_day']      = 5; //密码更新控制文件
$config['DB']['Pay']['withdrawNum']  = 10; //提现最小金额
$config['DB']['Pay']['factorage']  = 0.05; //手续费
$config['DB']['Pay']['coinLimitSmall']  = 1; //最低1元
$config['DB']['Pay']['coinLimitBig']  = 25; //最高25元
$config['DB']['Pay']['fee']  = 1000; //1000
?>