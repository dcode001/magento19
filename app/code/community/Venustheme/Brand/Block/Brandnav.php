<?php 
/*------------------------------------------------------------------------
 # VenusTheme Brand Module 
 # ------------------------------------------------------------------------
 # author:    VenusTheme.Com
 # copyright: Copyright (C) 2012 http://www.venustheme.com. All Rights Reserved.
 # @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 # Websites: http://www.venustheme.com
 # Technical Support:  http://www.venustheme.com/
-------------------------------------------------------------------------*/
class Venustheme_Brand_Block_Brandnav extends Venustheme_Brand_Block_List 
{

	
	/**
	 * Contructor
	 */
	public function __construct($attributes = array()){
		// Mage::helper('venustheme_brand/media')->addMediaFile( "js", "venustheme_brand/menu.js" );
		parent::__construct( $attributes );
	}
	
	public function _toHtml(){
		 
		$this->setTemplate( "venustheme/brand/block/brandnav.phtml" );
		
		$collection = Mage::getModel( "venustheme_brand/brand" )->getCollection();
		
		$this->assign( "brands", $collection );
		return parent::_toHtml();	
	}
	 
}
?>