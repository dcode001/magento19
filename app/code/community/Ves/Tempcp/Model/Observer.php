<?php

class Ves_Tempcp_Model_Observer {

    public function beforeRender(Varien_Event_Observer $observer) {
        $controller_name = Mage::app()->getRequest()->getControllerModule();
        $menu_name = $controller_name . "_" . Mage::app()->getRequest()->getControllerName();
        $helper = Mage::helper('ves_tempcp/data');
     //   if ($helper->checkAvaiable($controller_name)) {
            $config = $helper->get();
            $this->_loadMedia($config);
            if ($helper->checkMenuItem($menu_name, $config)) {
                /* Define Tempcp block */
                $layout = Mage::getSingleton('core/layout');
                $title = '';
                $position = isset($config["panelposition"])?$config["panelposition"]:'top.container';               
                //$display = isset($config["blockDisplay"]) ? $config["blockDisplay"] : "after";
                //$display = $display == "after" ? true : false;

                $source = 'cpanel';
                $block = $layout->createBlock('ves_tempcp/source_' . $source);
				if($cpanel = $layout->getBlock($position)){
					$cpanel->insert($block, $title, false);
				}
                /* End defined */
            }
     //   }
    }

    function _loadMedia($config = array()) {
        $mediaHelper = Mage::helper('ves_tempcp/media');
		if(isset($config["enablejquery"]) && $config["enablejquery"] == 1){
			$mediaHelper->addMediaFile("js", "ves_tempcp/jquery.js");
		}
        $mediaHelper->addMediaFile("js", "ves_tempcp/script.js");
    }

}
