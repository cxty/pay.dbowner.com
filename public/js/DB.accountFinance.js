/**
 * wbqing405@sina.com
 * 
 * 账户信息
 */
function TaccountFinance(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
TaccountFinance.prototype.init = function(){
	$('#show_msg').show();
	$('#modify_msg').hide();
	$('#modify').click(function(){
		$('#show_msg').hide();
		$('#modify_msg').show();
	});
};