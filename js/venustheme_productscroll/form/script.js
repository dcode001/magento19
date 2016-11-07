// JavaScript Document
jQuery.noConflict();
(function($) {
	
    $(document).ready(function(){
		var group = ['catalog', 'file'];
		var selector = 'venustheme_productscroll_venustheme_productscroll_source';
		selectOption.checkHide(selector,group);
		selectOption.actionShow(selector,group);
    });
	var selectOption = {
		checkHide : function(selector,group){
			var current = $('#' + selector).val();
			$.each(group, function(index, value) { 
				var item = $('#venustheme_productscroll_'+value+'_source_setting-head').parent();
				var content = $('#venustheme_productscroll_'+value+'_source_setting');
				if(current !== value){
					item.hide();
					content.hide();
				}else{
					item.show();
					content.show();
				}
			});
		},
		actionShow : function(selector, group){
			$('#' + selector).change(function(item){
				var current = $(this).val();
				$.each(group, function(index, value) { 
					var item = $('#venustheme_productscroll_'+value+'_source_setting-head').parent();
					var content = $('#venustheme_productscroll_'+value+'_source_setting');
					if(current !== value){
						item.hide();
						content.hide();
					}else{
						item.show();
						content.show();
					}
				});
			});
		}
	};
})(jQuery);


