/**
 * wbqing405@sina.com
 * 
 * 现金和D币转化
 */
function Tchange(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tchange.prototype.init = function(){	
	$('#sub_btn').click(function(){
		change.doclick();
	});
	
	$('input:text[name="coin"]').keyup(function(){
		var coin = ( !isNaN( $('input:text[name="coin"]').val() ) && parseInt( $('input:text[name="coin"]').val() ) > 0 ) ? $('input:text[name="coin"]').val() : 0;
		$('input:text[name="db"]').val(coin*change.jsonData.rate)
		coin = null;
	});
	$('input:text[name="db"]').keyup(function(){
		var db = ( !isNaN( $('input:text[name="db"]').val() ) && parseInt( $('input:text[name="db"]').val() ) > 0 ) ? $('input:text[name="db"]').val() : 0;
		$('input:text[name="coin"]').val(db/change.jsonData.rate)
		db = null;
	});
};
Tchange.prototype.formatFloat = function(src, pos){
    return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
};
Tchange.prototype.doclick = function(){
	var coin = $('input:text[name="coin"]').val() ? $('input:text[name="coin"]').val() : 0;
	if(coin === 0){
		Boxy.alert( change.JS_LANG.NotEmptyCoin ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: change.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}
	if(coin == 0){
		Boxy.alert( change.JS_LANG.ChargeGreaterThanZero ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: change.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}
	if( isNaN( coin ) ){
		Boxy.alert( change.JS_LANG.ChargeValueNum ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: change.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}else{
		var money = change.formatFloat($('input:text[name="coin"]').val(), 2);
		if( money <= 0){
			Boxy.alert( change.JS_LANG.ChargeGreaterThanZero ,
					function(){
						$('input:text[name="coin"]').val('').focus();
					},
					{title: change.JS_LANG.Remind ,modal:true,unloadOnHide:true}
			);
			return;
		}
	}

	var remind = '';
	var paytype = $('input:radio[name="paytype"]:checked').val();
	if(paytype == 'paypal'){
		var totalCoin = (coin/change.jsonData.parities).toFixed(2);
		remind = change.JS_LANG.RemindPay_1 + '&nbsp;<span class="c_y">' + change.jsonData.parities + '</span><br />' + change.JS_LANG.RemindPay_2 + '&nbsp;<span class="c_y">' + coin + '（CNY）/&nbsp;' + change.jsonData.parities + '&nbsp;=&nbsp;'+ totalCoin +'（USD）</span>';
		remind += '<br />' + change.JS_LANG.RemindPay_4 + '&nbsp;<span class="c_y">' + coin + '（CNY）*&nbsp;' + change.jsonData.rate + '&nbsp=&nbsp;' + (coin*change.jsonData.rate) + change.JS_LANG.IntegralBalanceUnion + '</span>';
		coin = totalCoin + '-' + coin;
	}else{
		remind = change.JS_LANG.RemindPay_2 + '&nbsp<span class="c_y">' + coin + '（CNY）</span>';
		remind += '<br />' + change.JS_LANG.RemindPay_4 + '&nbsp;<span class="c_y">' + coin + '（CNY）*&nbsp;' + change.jsonData.rate + '&nbsp=&nbsp;' + (coin*change.jsonData.rate) + change.JS_LANG.IntegralBalanceUnion + '</span>';
	}
	remind += '<br /><span class="pay_remind">' + change.JS_LANG.RemindPay_3 + '</span>';

	window.open('/assets/payment-' + paytype + '-' + coin + '-' + change.jsonData.type);
	
	Boxy.confirm(  remind ,
			function(){
				window.location.href = '/trade/db';
			},
			{title: change.JS_LANG.Remind ,modal:true,unloadOnHide:true}
	);
};