/**
 * wbqing405@sina.com
 * 
 * 现金充值
 */
function Tdeposit(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Tdeposit.prototype.init = function(){
	$('#sub_btn').click(function(){
		deposit.subClick();
	});	
};
Tdeposit.prototype.subClick = function(){
	var coin = $('input:text[name="coin"]').val() ? $('input:text[name="coin"]').val() : 0;
	if(coin === 0){
		Boxy.alert( deposit.JS_LANG.NotEmptyCoin ,
				function(){
					$('input:text[name="coin"]').focus();
				},
				{title: deposit.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);
	}else{
		var remind = '';
		var paytype = $('input:radio[name="paytype"]:checked').val();
		if(paytype == 'paypal'){
			var totalCoin = (coin/deposit.jsonData.rate).toFixed(2);
			remind = deposit.JS_LANG.RemindPay_1 + '&nbsp;<span class="c_y">' + deposit.jsonData.rate + '</span><br />' + deposit.JS_LANG.RemindPay_2 + '&nbsp;<span class="c_y">' + coin + '&nbsp;(CNY)&nbsp;/&nbsp;' + deposit.jsonData.rate + '&nbsp;=&nbsp;'+ totalCoin +'&nbsp;(USD)</span>';
			coin = totalCoin + '-' + coin;
		}else{
			remind = deposit.JS_LANG.RemindPay_2 + '&nbsp<span class="c_y">' + coin + '</span>&nbsp(CNY)';
			totalCoin = coin;
		}
		remind += '<br /><span class="pay_remind">' + deposit.JS_LANG.RemindPay_3 + '</span>';
		
		window.open('/assets/payment-' + paytype + '-' + coin);
		
		Boxy.alert(  remind ,
				function(){
					window.location.href = '/trade/cash';
				},
				{title: deposit.JS_LANG.Remind ,modal:true,unloadOnHide:true}
		);	
	}
};