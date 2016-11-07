<?php

/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class Ves_Megamenu_Model_Observer {

    public function beforeRender(Varien_Event_Observer $observer) {
		
		$this->_loadMedia();
    }
	public function isAdmin()
    {
        if(Mage::app()->getStore()->isAdmin()) {
            return true;
        }

        if(Mage::getDesign()->getArea() == 'adminhtml') {
            return true;
        }
        return false;
    }
	
    function _loadMedia($config = array()) {
        $mediaHelper = Mage::helper('ves_megamenu/media');
      
		if( $this->isAdmin() ){
			$mediaHelper->addMediaFile("js", "ves_megamenu/jquery.js");
			$mediaHelper->addMediaFile("js", "ves_megamenu/jquery.simple.tree.js");
		}else {
			if( Mage::getStoreConfig("ves_megamenu/ves_megamenu/show") ) { 
				if ( !defined("_LOAD_JQUERY_") &&  Mage::getStoreConfig("ves_megamenu/ves_megamenu/enable_jquery")  ) {
					$mediaHelper->addMediaFile("js", "ves_megamenu/jquery.js");
					define( "_LOAD_JQUERY_",1 );
				}
				$mediaHelper->addMediaFile("js", "ves_megamenu/ddsmoothmenu.js");
			}	
		}
    }
}
