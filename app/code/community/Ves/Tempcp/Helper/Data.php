<?php

class Ves_Tempcp_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getApplyPostUrl(){
        return $this->_getUrl('tempcp');
    }
    
    public function checkAvaiable($controller_name = "") {
        $arr_controller = array("Mage_Cms",
            "Mage_Catalog",
            "Mage_Tag",
            "Mage_Checkout",
            "Mage_Customer",
            "Mage_Wishlist",
            "Mage_CatalogSearch");
        if (!empty($controller_name)) {
            if (in_array($controller_name, $arr_controller)) {
                return true;
            }
        }
        return false;
    }

    public function checkMenuItem($menu_name = "", $config = array()) {
        if (!empty($menu_name) && !empty($config)) {
            $menus = isset($config["menuAssignment"]) ? $config["menuAssignment"] : "all";
            $menus = explode(",", $menus);
            if (in_array("all", $menus) || in_array($menu_name, $menus)) {
                return true;
            }
        }
        return false;
    }

    public function getListMenu() {
        $arrayParams = array(
            'all' => Mage::helper('adminhtml')->__("All"),
            'Mage_Cms_index' => Mage::helper('adminhtml')->__("Mage Cms Index"),
            'Mage_Cms_page' => Mage::helper('adminhtml')->__("Mage Cms Page"),
            'Mage_Catalog_category' => Mage::helper('adminhtml')->__("Mage Catalog Category"),
            'Mage_Catalog_product' => Mage::helper('adminhtml')->__("Mage Catalog Product"),
            'Mage_Customer_account' => Mage::helper('adminhtml')->__("Mage Customer Account"),
            'Mage_Wishlist_index' => Mage::helper('adminhtml')->__("Mage Wishlist Index"),
            'Mage_Customer_address' => Mage::helper('adminhtml')->__("Mage Customer Address"),
            'Mage_Checkout_cart' => Mage::helper('adminhtml')->__("Mage Checkout Cart"),
            'Mage_Checkout_onepage' => Mage::helper('adminhtml')->__("Mage Checkout"),
            'Mage_CatalogSearch_result' => Mage::helper('adminhtml')->__("Mage Catalog Search"),
            'Mage_Tag_product' => Mage::helper('adminhtml')->__("Mage Tag Product")
        );
        return $arrayParams;
    }

    public function get($attributes = NULL) {
        $data = array();
        $arrayParams = array(
		'font_setting' =>	array(
			'enable_customfont',
            'fonturl1',
			'fontfamily1',
			'fontselectors1',
			'fonturl2',
			'fontfamily2',
			'fontselectors2',
				'fonturl3',
			'fontfamily3',
			'fontselectors3',
			
			'fonturl4',
			'fontfamily4',
			'fontselectors4'
		), 
		'ves_tempcp' => array(
			'templatewidth',
            'skin',
            'layout',
            'paneltool',
            'responsive',
			'enablejquery',
			'panelposition',
            'backgroundpattern'
			
		)	
        );

        foreach ($arrayParams as $tag => $vars) {
          
            foreach ($vars as $var ) {
               // if (Mage::getStoreConfig("ves_tempcp_info/$tag/$var") != "") {
                    $data[$var] = Mage::getStoreConfig("ves_tempcp_info/$tag/$var"); //item config
            //    }
            }
            if (isset($attributes[$var])) {
               $data[$var] = $attributes[$var];
            }
        }
 
        return $data;
    }

    public function getImageUrl($url = null) {
        return Mage::getSingleton('ves_tempcp/config')->getBaseMediaUrl() . $url;
    }

    /**
     * Encode the mixed $valueToEncode into the JSON format
     *
     * @param mixed $valueToEncode
     * @param  boolean $cycleCheck Optional; whether or not to check for object recursion; off by default
     * @param  array $options Additional options used during encoding
     * @return string
     */
    public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array()) {
        $json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
        /* @var $inline Mage_Core_Model_Translate_Inline */
        $inline = Mage::getSingleton('core/translate_inline');
        if ($inline->isAllowed()) {
            $inline->setIsJson(true);
            $inline->processResponseBody($json);
            $inline->setIsJson(false);
        }

        return $json;
    }
    
    public function getThemeInfo($is = 0) {
        
		if($is){
			$path = str_replace('adminhtml'.DS,'',Mage::getSingleton('core/design_package')->getSkinBaseDir(array('_package' => 'frontend\default')));
			//var_dump($path); echo "<br/>";
			$path = str_replace( "\\", DS, $path );
		}else{
			$path = Mage::getSingleton('core/design_package')->getSkinBaseDir();
			//var_dump($path); echo "<br/>";
		}
		
		//die;
		
        $info = null;
        if(is_file($path . '/config.xml')){
            $info = simplexml_load_file($path . '/config.xml');
        }

        if (!$info || !isset($info->name) || !isset($info->positions)) {
            return null;
        }
        $p = (array) $info->positions;
        $output = array("skins" => "", "positions" => $p["position"], "name" => (string) $info->name);
        if (isset($info->skins)) {
            $tmp = (array) $info->skins;
            $output["skins"] = $tmp["skin"];
        }
        $output = $this->onGetInfo( $path, $output );
		
        return $output;
    }
    
    public function onGetInfo($fpath, $output = array()) {
        $output["patterns"] = array();
		
		$path = $fpath. '/images/patterns';
		
        $regex = '/(\.gif)|(.jpg)|(.png)|(.bmp)$/i';
        if($dk = opendir($path)){
			$files = array();
			while (false !== ($filename = readdir($dk))) {
				if (preg_match($regex, $filename)) {
					$files[] = $filename;
				}
			}
			$output["patterns"] = $files;
		}
        return $output;
    }
}

?>