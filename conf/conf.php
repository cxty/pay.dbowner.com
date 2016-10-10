<?php
//数据库配置
$config['DB_TYPE']					='mysql';							//数据库类型
$config['DB_HOST']					='192.168.0.198';//'192.168.0.253';					//数据库主机
$config['DB_USER']					='pay_db';//'cxty';							//数据库用户名
$config['DB_PWD']					='1f30e549';//'1q2w3e';							//数据库密码
$config['DB_PORT']					=3306;							//数据库端口，mysql默认是3306
$config['DB_NAME']					='pay_db';				//数据库名
$config['DB_CHARSET']				='utf8';						//数据库编码
$config['DB_PREFIX']				='';						//数据库前缀
$config['DB_PCONNECT']				=false;						//true表示使用永久连接，false表示不适用永久连接，一般不使用永久连接

$config['DB_CACHE_ON']				=false;						//是否开启数据库缓存，true开启，false不开启
$config['DB_CACHE_PATH']			='./cache/db_cache/';		//数据库查询内容缓存目录，地址相对于入口文件
$config['DB_CACHE_TIME']			=600;						//缓存时间,0不缓存，-1永久缓存
$config['DB_CACHE_CHECK']			=true;						//是否对缓存进行校验
$config['DB_CACHE_FILE']			='cachedata';				//缓存的数据文件名
$config['DB_CACHE_SIZE']			='15M';						//预设的缓存大小，最小为10M，最大为1G
$config['DB_CACHE_FLOCK']			=true;						//是否存在文件锁，设置为false，将模拟文件锁

//OAuth2 站内访问
$config['oauth']['client_id']      = 'app22';
$config['oauth']['client_secret']  = '664d8ef9b1c838fa59e76d56eda5c454';
$config['oauth']['redirect_uri']   = 'http://pay.dbowner.com/login/callback';
$config['oauth']['authorizeURL']   = 'https://auth.dbowner.com/oauth/authorize';
$config['oauth']['accessTokenURL'] = 'https://auth.dbowner.com/oauth/token2';
$config['oauth']['host']           = 'https://auth.dbowner.com';
// $config['oauth']['authorizeURL']   = 'http://user.dbowner.com/oauth/authorize';
// $config['oauth']['accessTokenURL'] = 'http://user.dbowner.com/oauth/token2';
// $config['oauth']['host']           = 'http://user.dbowner.com';


//支付统一配置
$config['pay']['return_url'] = 'http://pay.dbowner.com/callback/success';
$config['pay']['cancel_url'] = 'http://pay.dbowner.com/callback/cancel';
$config['pay']['notify_url'] = 'http://pay.dbowner.com/callback/notify';
$config['pay']['mo_return_url'] = 'http://pay.dbowner.com/mobile/success';
$config['pay']['mo_cancel_url'] = 'http://pay.dbowner.com/mobile/cancel';
$config['pay']['mo_notify_url'] = 'http://pay.dbowner.com/mobile/notify';
$config['pay']['mo_merchant_url'] = 'http://pay.dbowner.com/mobile/merchant';
$config['pay']['show_url'] = 'http://pay.dbowner.com';

//paypal配置
$config['pay']['paypal']['host'] = 'https://api.paypal.com';
$config['pay']['paypal']['client_id'] = 'AfNKThBsXgJdn4-GlV2AC_Ojw1H1j029YffYyn2PngdCXBB4lX_STbgNLX8h';
$config['pay']['paypal']['secret'] = 'EIDgXxBd6XVeTXSCz_ooVG5OwRQqlOK-hz7wHiPkeaVBbYuawdFsZomJx1lW';
$config['pay']['paypal']['intent'] = 'sale';
$config['pay']['paypal']['currency'] = 'USD';

//alipay配置
$config['pay']['alipay']['host'] = 'https://api.sandbox.paypal.com';
$config['pay']['alipay']['partner'] = '2088101190850814';
$config['pay']['alipay']['key'] = 'vz3pml3fru55s2b8kypr0n09im55s3zb';
$config['pay']['alipay']['seller_email'] = 'cxty@yannyo.com';
$config['pay']['alipay']['account_name'] = '福州燕游网络科技有限公司';
$config['pay']['alipay']['payment_type'] = 1; //支付类型
$config['pay']['alipay']['sign_type']    = strtoupper('MD5'); //签名方式 不需修改
$config['pay']['alipay']['anti_phishing_key']    = ''; //防钓鱼时间戳
$config['pay']['alipay']['exter_invoke_ip']    = ''; //客户端的IP地址
$config['pay']['alipay']['input_charset']= strtolower('utf-8'); //字符编码格式 目前支持 gbk 或 utf-8
$config['pay']['alipay']['cacert']    = getcwd().'\\include/ext/pay/alipay/cacert.pem'; //ca证书路径地址，用于curl中ssl校验
$config['pay']['alipay']['transport']    = 'http'; //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$config['pay']['alipay']['wrap_format']  = 'xml';
$config['pay']['alipay']['wrap_v']  = '2.0';
//$config['pay']['alipay']['sign_type']    = '0001'; //签名方式 不需修改
$config['pay']['alipay']['private_key_path']    = getcwd().'\\include/ext/pay/partner/alipay/rsa_private_key.pem';
$config['pay']['alipay']['ali_public_key_path']    = getcwd().'\\include/ext/pay/partner/alipay/alipay_public_key.pem';
