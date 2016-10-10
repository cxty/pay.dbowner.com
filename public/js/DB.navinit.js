/**
 * wbqing405@sina.com
 * 
 * 现金明细处理
 */
function Tnavinit(){
	
};
Tnavinit.prototype.init = function(){
	$( "#startTime" ).datepicker({
		"dateFormat": "yy-mm-dd",
		"showAnim": "slideDown",
	});
	$( "#endTime" ).datepicker({
		"dateFormat": "yy-mm-dd",
		"showAnim": "slideDown",
	});
	
	$('.trade_box').height($('.trade_right').height()+50);
	$('.trade_content').height($('.trade_right').height()-30);
	
	$('#sub_btn').click(function(){
		$('#myform').submit();
	});
};