// JavaScript Document

document.observe("dom:loaded", function() {
		
		var group = ['catalog','image','file'];
		
		Event.observe( $("lof_slider_lof_slider_source"),'change', function(){
			_update( this.value );																	
		} );
		
			 $$("#lof_slider_lof_slider_source option").each( function(item){
				group.push(item.value)	;		
			} );
		  $$("#lof_slider_lof_slider_source option").each( function(item){

			if( item.selected ){
				_update( item.value);
			}
			
		} );
		function _update( groupShow ){
			group.each( function(item){
					var groupName = 'lof_slider_'+item+'_source_setting';
					var groupHeader = 'lof_slider_'+item+'_source_setting-head';
					if( item==groupShow ){
						$(groupHeader).up('div.entry-edit-head').show();
						$(groupName).show();
						$(groupName+"-state").value = 1;
					} else {
						$(groupName+"-state").value = 0;
						$(groupHeader).up('div.entry-edit-head').hide();
						$(groupName).hide();
					}
			} );
			
		}
 
});
