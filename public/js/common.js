
function TCommon(){
	this.IsShowLang = null;
}
TCommon.prototype.init = function(){
	Common.Lang($('#lang_box'),Common.getLang()); //语言
};
//语言切换
TCommon.prototype.Lang = function(sObj,Selected){
	var Lang = [{lang:'简体中文',code:'zh'},{lang:'English',code:'en'}];
	if(sObj){
		var _html = '';
		var _SelectedHtml = Lang[0].lang;
		var _t = this.GetRequest();
		for(var i=0;i<Lang.length;i++){
			_url = _t;
			_url['lang']=Lang[i].code;
			
			if (Lang[i].code == Selected) {
				_SelectedHtml = Lang[i].lang;
			}
			
			_html += '<li><a href="?' + this.http_build_query(_url) + '">' + Lang[i].lang + '</a></li>';
			
		}
		_html = '<a href="javascript:void(0);" id="LangTxt">'+_SelectedHtml+ '</a> <div id="LangBar">'+_html+'</div>';
		$(sObj).html(_html);
		$('#LangBar').hide();
		$(sObj).click(function(){
			if (Common.IsShowLang) {
				$('#LangBar').hide();
				Common.IsShowLang = false;
			}
			else {
				Common.IsShowLang = true;
				var _lboxOffset = $('#LangTxt').offset();
				var _top = _lboxOffset.top+30;
				var _left = _lboxOffset.left-$('#LangBar').width()/2;
				$('#LangBar').css({'top':_top+'px','left':_left+'px','position': 'absolute','z-index':999});
				$('#LangBar a').css({'color':'#fff'});
				$('#LangBar').show('normal').delay(5000).hide('normal',function(){
					Common.IsShowLang = false;
				});
			}
		});
	}
};
//取url参数
TCommon.prototype.GetRequest = function() {
   var url = location.search; //获取url中"?"符后的字串
   var theRequest = new Array();
   
   if (url.indexOf("?") != -1) {  
      var str = url.substr(1);
      strs = str.split("&");
      
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
      }
      
   }

   return theRequest;
};
//生成url
TCommon.prototype.http_build_query = function(_params){
	var _re = '';
	if(_params)
	{
		for(key in _params){
			 value = _params[key];
			 _re += key+'='+value+'&';
		}
	}
	_re = _re.substring(0,_re.length-1);
	return _re;
};
//取当前语言
TCommon.prototype.getLang = function(){
   var url = location.search; //获取url中"?"符后的字串
   var cp_lang = Common.getCookie('cp_languages');
   var _lang = cp_lang == null ? 'zh' : cp_lang;
   
   if (url.indexOf("?") != -1) {  
      var str = url.substr(1);
      strs = str.split("&");
      
      for(var i = 0; i < strs.length; i ++) {
    	  if(unescape(strs[i].split("=")[0]) == 'lang'){
    		  _lang = unescape(strs[i].split("=")[1]);
    	  }
      }
   }
   
   return _lang;
};
//取cookies值
TCommon.prototype.getCookie = function (name) { 
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]); 
    else 
        return null; 
};