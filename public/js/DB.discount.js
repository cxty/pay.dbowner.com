/**
 * wbqing405@sina.com
 * 
 * 现金和D币转化
 */
function Tdiscount(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tdiscount.prototype.init = function(){
	$('#sub_btn').click(function(){
		discount.doclick();
	});
};
Tdiscount.prototype.formatFloat = function(src, pos){
    return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
};
Tdiscount.prototype.doclick = function(){
	var coin = parseInt($('input:text[name="coin"]').val() ? $('input:text[name="coin"]').val() : 0);
	if(coin === 0){
		Boxy.alert( discount.JS_LANG.NotEmptyCoin ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}
	if(coin == 0){
		Boxy.alert( discount.JS_LANG.ChargeGreaterThanZero ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}
	if( isNaN( coin ) ){
		Boxy.alert( discount.JS_LANG.ChargeValueNum ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}else{
		var money = discount.formatFloat($('input:text[name="coin"]').val(), 2);
		if( money <= 0){
			Boxy.alert( discount.JS_LANG.ChargeGreaterThanZero ,
					function(){
						$('input:text[name="coin"]').val('').focus();
					},
					{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
			);
			return;
		}
	}
	if(coin < discount.jsonData.withdrawNumDB){
		Boxy.alert( discount.JS_LANG.ChargeGreaterThanWithdrawNum + '<span class="c_y">&nbsp;' + discount.jsonData.withdrawNumDB + '</span>',
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}
	if(coin > discount.jsonData.db){
		Boxy.alert( discount.JS_LANG.ChargeSmallerThanWithdrawNum + '<span class="c_y">&nbsp;' + coin + discount.jsonData.db + '</span>' ,
				function(){
					$('input:text[name="coin"]').val('').focus();
				},
				{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
		return;
	}

	var remind = '';
	totalCoin = discount.formatFloat((coin/discount.jsonData.rate), 2);
	remind = discount.JS_LANG.RemindPay_5 + '&nbsp<span class="c_y">' + coin + discount.JS_LANG.IntegralBalanceUnion + '</span>';
	remind += '<br />' + discount.JS_LANG.RemindPay_4 + '&nbsp;<span class="c_y">' + coin + discount.JS_LANG.IntegralBalanceUnion + '/&nbsp;' + discount.jsonData.rate + '&nbsp=&nbsp;' + totalCoin + '（CNY）</span>';
	var factorage = 0;
	if(totalCoin <= discount.jsonData.smallCoinNum){
		factorage = discount.jsonData.coinLimitSmall;
	}else if(totalCoin > discount.jsonData.bigCoinNum){
		factorage = discount.jsonData.coinLimitBig;
	}else{
		factorage = totalCoin * discount.jsonData.factorage
	}
	remind += '<br />' + discount.JS_LANG.RemindPay_7 + '&nbsp;<span class="c_y">&nbsp;' + factorage + '（CNY）</span>';

	Boxy.confirm(  remind ,
			function(){
				window.location.href = '/assets/adddiscounting-' + coin;
			},
			{title: discount.JS_LANG.Remind ,modal:true,unloadOnHide:true}
	);	
};