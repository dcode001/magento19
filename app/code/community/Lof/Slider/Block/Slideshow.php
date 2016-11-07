<?php 
class Lof_Slider_Block_Slideshow extends Lof_Slider_Block_List 
{
	public function _toHtml(){
		$source = $this->getConfig( "source" );
		if( $source ){ 
			return $this->getLayout()->createBlock("lof_slider/".$source)->toHtml();
		}
	 
	}
}
?>