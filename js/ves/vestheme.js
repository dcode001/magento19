jQuery(function($){
	
	$( ".vesdropdown" ).each( function(){
			var _this = this
			$(".selected", this).click(function(){
			if($('.dropdown-wrapper', _this).css('display') == 'none'){
				$('.dropdown-wrapper', _this).slideDown(500);
			}else{
				$('.dropdown-wrapper', _this).slideUp(500);
			}
		});	
	} );
 




});