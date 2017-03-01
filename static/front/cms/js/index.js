$(function(){
	//轮播图
	jQuery(".bigImages").slide({mainCell:".bd ul",autoPlay:true,effect:"left",interTime:4500});


	//中医名家
	jQuery(".mingjia").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:true,vis:3,trigger:"click"});


	//导航栏
	$('.menu li').hover(function(){
		$(this).find('>ul').stop().fadeIn(200)
		$(this).parents('li').find('>a').addClass('current')
	},function(){
		$(this).find('>ul').fadeOut(100);
		$(this).parents('li').find('a').removeClass('current')

	})

	//Search
	$(".search .text").val("请输入视频名称").css("color","#e0e0df");
  $(".search .text").focus(function(){
		if($(this).val() == "请输入视频名称"){
    	$(this).val("").css("color","#555")
		}
	});

  $(".search .text").blur(function(){
		var _this = $(".search .text")
    if( _this.val() == ""){
    	_this.val("请输入视频名称").css("color","#e0e0df")
    }

  });

	//vide nav
	$('.video-left-ul>ul>li').on('click',function(){
		$(this).addClass('current').find('ul').toggle().parents('li').siblings().removeClass('current').find('ul').hide();
	})



})

//加入收藏夹
function AddFvtgc() {
 var title = document.title;
 var url = document.location.href;
 try {
  window.external.AddFavorite(url, title);
 }
 catch (e) {
  alert("请按下 Ctrl + D 键将本站加入收藏。");
 }
}

//设为首页
function AddHomegc() {
 var url = document.location.href; if (document.all)
 { document.body.style.behavior = 'url(#default#homepage)'; document.body.setHomePage(url); }
 else if (window.sidebar) {
  if (window.netscape) {
   try { netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); }
   catch (e)
   { alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将[signed.applets.codebase_principal_support]设置为'true'"); }
  }
  //var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
  //prefs.setCharPref('browser.startup.homepage', url);
 }
 else {
  alert('您的浏览器不支持自动自动设置首页, 请使用浏览器菜单手动设置!');
 }
}

//获取当前时间
GetCurTime();
function GetCurTime() {
    webtime = document.getElementById('jnkc');
    webtime.innerHTML = new Date().getFullYear() + '年' + eval(new Date().getMonth() + 1) + '月' + new Date().getDate() + '日' + ' 星期' + '日一二三四五六'.charAt(new Date().getDay()) + ' ' ;
}
