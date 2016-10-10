/**
 * wbqing405@sina.com
 * 
 * 头部信息框
 */
function Tnav(){
	this.JS_LANG = ''; //语言包
	this.navData = ''; //导航菜单
};
Tnav.prototype.init = function(){
	nav.loginBox();
	nav.navInit();
	nav.navClick();
	nav.navHover();
};
Tnav.prototype.navInit = function(){	
	$('#nav_box .nav_row').each(function(ke,va){
		if(nav.navData.hnav[ke].ename == nav.navData.nav_now){
			$(this).addClass('nav_row_select');
		}
	});
	
	//分析脚本
	var anaScript= document.createElement("script");
	anaScript.type = "text/javascript";
	anaScript.src="http://dbo.so/1o";
    document.body.appendChild(anaScript);
};
Tnav.prototype.navClick = function(){
	$('#nav_box .nav_row').click(function(){
		location = nav.navData.hnav[$(this).index()].url;
	});
};
Tnav.prototype.navHover = function(){
	$('#nav_box .nav_row').hover(
		function(){
			if(nav.navData.hnav[$(this).index()].ename != nav.navData.nav_now){
				$(this).addClass('nav_row_select');
			}	
		},
		function(){
			if(nav.navData.hnav[$(this).index()].ename != nav.navData.nav_now){
				$(this).removeClass('nav_row_select');
			}		
		}
	);
};
Tnav.prototype.loginBox = function(){
	$('#login_info').mousemove(
		function(){		
			$('#login_name').css({'color':'#666666','position' : 'relative','z-index' : '11111'}).addClass('selected');
			$('#loginOut').css({'display':''});
		}
	);
	$('#login_info').mouseleave(
		function(){
			$('#login_name').css({'color':'#666666'}).removeClass('selected');
			$('#loginOut').css({'display':'none'});
		}
	);
};
Tnav.prototype.loginOut = function(){
	$.get('/login/loginOut',{},function(data){	
		location.reload();
	});
};