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

class Venustheme_Brand_BrandController extends Mage_Core_Controller_Front_Action
{  	
	public function indexAction(){
		 
	 
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function viewAction(){
		$id = (int) $this->getRequest()->getParam( 'id', false);
        $brand = Mage::getModel('venustheme_brand/brand')->load( $id );
        Mage::register('current_brand', $brand);

		$this->loadLayout();
		$this->renderLayout();
	}
}
?>