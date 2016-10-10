/**
 * wbqing405@sina.com
 * 
 * 交易管理左边导航
 */
function Tnavtrade(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tnavtrade.prototype.init = function(){
	$('.td_ul_left li').click(function(){
		navtrade.doliclick($(this).index());
	});
};
Tnavtrade.prototype.doliclick = function(num){
	$('.td_ul_left li').each(function(ke, va){
		if(ke == num){
			$(this).addClass('td_ul_select');
		}else{
			$(this).removeClass('td_ul_select');
		}
		location = navtrade.jsonData.tradeNav[num].url;
	});
};