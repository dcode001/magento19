
jQuery(function($) {	
	$widthli = $("#nav > li > ul > li").width();	
	$("#nav li.parent").hover(function(){
		$("#nav > li > ul > li.last").prev().removeClass("no-border");
		$countLi=($(this).find('ul:first > li').size());
		/*
		if($countLi > 3)
		{			
			
		}
		else
		{
			$("#nav > li > ul").css('width',$widthli+15);			
		}
		*/
		
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(300); 
		},function(){ 
		$(this).find('ul:first').css({visibility: "hidden"}); 
	});
	$("#nav > li.parent").append('<span class="bg-parent"></span>');
	$("#nav-res > li.parent").append('<span class="bg-parent"></span>');
	
	$(".res-320 h2").click(function(){
		$navres = $(this).parent().find('#nav-res');
		if($navres.is(":hidden")){
			$navres.slideDown("fast").show();
		}
		else
		{
			$navres.slideUp("fast");
		}
	});
	
	$("#nav-res .bg-parent").click(function(){
		$sub = $(this).parent().find('ul.level0');
		$('ul.level0').slideUp("fast");
		if($sub.is(":hidden"))
		{
			$sub.slideDown("fast").show();			
		}
		else
		{
			$sub.slideUp("fast");	
		}
	});

});
 