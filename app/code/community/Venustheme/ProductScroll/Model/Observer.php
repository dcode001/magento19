<?php
class Venustheme_ProductScroll_Model_Observer
{
   public function beforeRender( Varien_Event_Observer $observer ){
		$this->_loadMedia(); 
   }
   
   function _loadMedia(  ){
		if( Mage::getStoreConfig("venustheme_productscroll/venustheme_productscroll/show") ) { 
			$mediaHelper =  Mage::helper('venustheme_productscroll/media');
			if(  Mage::getStoreConfig("venustheme_productscroll/venustheme_productscroll/enable_jquery")  ){		
				$mediaHelper->addMediaFile("js","venustheme_productscroll/jquery.js");
			}
			$mediaHelper->addMediaFile("js","venustheme_productscroll/script.js");
		}
	}
}
