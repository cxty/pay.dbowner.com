/*全局js*/

var Base = new TBase();

function TBase() {

}
TBase.prototype.init = function() {
	this.GoTop();
};
//回顶部按钮
TBase.prototype.GoTop = function(){

	if($("#back-to-top")){
		$("#back-to-top").hide();

		$('#back-to-top').offset({left:$('.back-to-top-box').offset().left+$('.back-to-top-box').width()});

		$(function() {
			$(window).scroll(function() {
				if ($(window).scrollTop() > 100) {
					$("#back-to-top").fadeIn(300);
				} else {
					$("#back-to-top").fadeOut(300);
				}
			});

			$("#back-to-top").click(function() {
				$('body,html').animate({
					scrollTop : 0
				}, 500);
				return false;
			});
		});
	}
};


$(document).ready(function() {
	
	Base.init();
	
});