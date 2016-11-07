<?php

class Venustheme_TreeMenu_Model_Observer {

    public function beforeRender(Varien_Event_Observer $observer) {
        $this->_loadMedia();
    }

    function _loadMedia($config = array()) {
		 if( Mage::getStoreConfig("venustheme_treemenu/venustheme_treemenu/show") ) { 
			$mediaHelper = Mage::helper('venustheme_treemenu/media');
			if(  Mage::getStoreConfig("venustheme_treemenu/venustheme_treemenu/enable_jquery")  ){	
				$mediaHelper->addMediaFile( "js", "venustheme_treemenu/jquery.js" );
			}
			$mediaHelper->addMediaFile( "js", "venustheme_treemenu/script.js" );
		}
    }

}
