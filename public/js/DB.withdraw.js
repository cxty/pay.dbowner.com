/**
 * wbqing405@sina.com
 * 
 * 提现
 */
function Twithdraw(){
	this.JS_LANG = ''; //语言包
	this.jsonData = ''; //导航菜单
};
Twithdraw.prototype.init = function(){
	$('#sub_btn').click(function(){
		var coin = parseInt( $('input:text[name="coin"]').val() );
		if(coin < parseInt( withdraw.jsonData.withdrawNum )){
			Boxy.alert( withdraw.JS_LANG.NotEmptyTakeMoney ,
					function(){
						$('input:text[name="coin"]').val('').focus();
					},
					{title: withdraw.JS_LANG.Remind ,modal:true,unloadOnHide:true}
			);
			return;
		}else if(coin  > withdraw.jsonData.money){
			Boxy.alert( withdraw.JS_LANG.NotEmptyTakeMoneyNum ,
					function(){
						$('input:text[name="coin"]').val('').focus();
					},
					{title: withdraw.JS_LANG.Remind ,modal:true,unloadOnHide:true}
			);
			return;
		}else{
			$('#myform').submit();
		}
	});	
};