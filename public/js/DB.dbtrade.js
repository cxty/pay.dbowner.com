/**
 * wbqing405@sina.com
 * 
 * D币明细处理
 */
function Tdbtrade(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tdbtrade.prototype.init = function(){
	$( "#startTime" ).datepicker({
		"dateFormat": "yy-mm-dd",
		"showAnim": "slideDown",
	});
	$( "#endTime" ).datepicker({
		"dateFormat": "yy-mm-dd",
		"showAnim": "slideDown",
	});
	
	$('.trade_box').height($('.trade_right').height()+50);
	
	$('#sub_btn').click(function(){
		$('#myform').submit();
	});
};
