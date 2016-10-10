/**
 * wbqing405@sina.com
 * 
 * 现金和D币转化
 */
function Tmochange(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tmochange.prototype.init = function(){
	$('#payway li').click(function(){
		mochange.doclick( $(this) );
	});
	
	$('input:text[name="coin"]').keyup(function(){
		var coinVal = $('input:text[name="coin"]').val();
		var coin = ( !isNaN( coinVal ) && parseInt( coinVal ) > 0 ) ? coinVal : 0;
		$('input:text[name="db"]').val(coin*mochange.jsonData.rate);
		coin = null;
	});
	$('input:text[name="db"]').keyup(function(){
		var dbVal = $('input:text[name="db"]').val();
		var db = ( !isNaN( dbVal ) && parseInt( dbVal ) > 0 ) ? dbVal : 0;
		$('input:text[name="coin"]').val(db/mochange.jsonData.rate);
		db = null;
	});
};
Tmochange.prototype.formatFloat = function(src, pos){
    return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
};
Tmochange.prototype.doclick = function( obj ){
	var coin = $('input:text[name="coin"]').val() ? $('input:text[name="coin"]').val() : 0;
	if(coin === 0){
		alert(mochange.JS_LANG.NotEmptyCoin);
		$('input:text[name="coin"]').val('').focus();
		return;
	}
	if(coin == 0){
		alert(mochange.JS_LANG.ChargeGreaterThanZero);
		$('input:text[name="coin"]').val('').focus();
		return;
	}
	if( isNaN( coin ) ){
		alert(mochange.JS_LANG.ChargeValueNum);
		$('input:text[name="coin"]').val('').focus();
		return;
	}else{
		var money = mochange.formatFloat($('input:text[name="coin"]').val(), 2);
		if( money <= 0){
			alert(mochange.JS_LANG.ChargeGreaterThanZero);
			$('input:text[name="coin"]').val('').focus();
			return;
		}
	}

	var remind = '';
	var paytype = obj.attr('vtype');
	if(paytype == 'paypal'){
		alert('还未调好接口，请更换支付宝！');return;
		var totalCoin = (coin/mochange.jsonData.parities).toFixed(2);
		remind = mochange.JS_LANG.RemindPay_8 + '\n' + mochange.JS_LANG.RemindPay_9 + mochange.jsonData.parities + '\n' + mochange.JS_LANG.RemindPay_2 +coin + '（CNY）/' + mochange.jsonData.parities + ' = '+ totalCoin +'（USD）\n';
		remind += mochange.JS_LANG.RemindPay_5 + coin + '（CNY）*' + mochange.jsonData.rate + ' = ' + (coin*mochange.jsonData.rate) + mochange.JS_LANG.IntegralBalanceUnion + '\n';
		coin = totalCoin + '-' + coin;
	}else{
		remind = mochange.JS_LANG.RemindPay_2 + coin + '（CNY）\n';
		remind += mochange.JS_LANG.RemindPay_5 + coin + '（CNY）* ' + mochange.jsonData.rate + ' = ' + (coin*mochange.jsonData.rate) + mochange.JS_LANG.IntegralBalanceUnion + '\n';
	}
	remind += mochange.JS_LANG.RemindPay_10;
	
	if ( confirm(remind) ) {
		window.location.href = '/mobile/payment-' + paytype + '-' + coin + '-' + mochange.jsonData.type;
	}
};

//页面完全再入后初始化
$(document).ready(function(){
	mochange =  new Tmochange();
	mochange.JS_LANG = JS_LANG;
	mochange.jsonData = jsonData;
	
	mochange.init();
});
//释放
$(window).unload(function(){
	mochange = null;
});