<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Lof * @package     Lof_Slider
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Helper Data
 *
 * @author      LandOfCoder <landofcoder@gmail.com>
 */
class Lof_Slider_Helper_Data extends Mage_Core_Helper_Abstract {
	
	public function checkAvaiable( $controller_name = ""){
		 $arr_controller = array(  "Mage_Cms",
											"Mage_Catalog",
											"Mage_Tag",
											"Mage_Checkout",
											"Mage_Customer",
											"Mage_Wishlist",
											"Mage_CatalogSearch");
		 if( !empty($controller_name)){
			if( in_array( $controller_name, $arr_controller ) ){
				return true;
			}
		 }
		 return false;
   }
	public function checkMenuItem( $menu_name = "", $config = array())
	{
		if(!empty( $menu_name) && !empty( $config)){
			$menus = isset($config["menuAssignment"])?$config["menuAssignment"]:"all";
			$menus = explode(",", $menus);
			if( in_array("all", $menus) || in_array( $menu_name, $menus) ){
				return true;
			}
		}
		return false;
	}
	public function getListMenu(){
		$arrayParams = array(
							 'all'=>Mage::helper('adminhtml')->__("All"),
							 'Mage_Cms_index'=>Mage::helper('adminhtml')->__("Mage Cms Index"),
							 'Mage_Cms_page'=>Mage::helper('adminhtml')->__("Mage Cms Page"),
							 'Mage_Catalog_category'=>Mage::helper('adminhtml')->__("Mage Catalog Category"),
							 'Mage_Catalog_product'=>Mage::helper('adminhtml')->__("Mage Catalog Product"),
							 'Mage_Customer_account'=>Mage::helper('adminhtml')->__("Mage Customer Account"),
							 'Mage_Wishlist_index'=>Mage::helper('adminhtml')->__("Mage Wishlist Index"),
							 'Mage_Customer_address'=>Mage::helper('adminhtml')->__("Mage Customer Address"),
							 'Mage_Checkout_cart'=>Mage::helper('adminhtml')->__("Mage Checkout Cart"),
							 'Mage_Checkout_onepage'=>Mage::helper('adminhtml')->__("Mage Checkout"),
							 'Mage_CatalogSearch_result'=>Mage::helper('adminhtml')->__("Mage Catalog Search"),
							 'Mage_Tag_product'=>Mage::helper('adminhtml')->__("Mage Tag Product")
							 );
		return $arrayParams;
	}
	function get( $attributes )
	{
		$data = array();
		$arrayParams = array('show', 
							'name',
		                     'title', 
		                     'theme', 
		                     'enable_css3', 
		                     'shadow', 
		                     'moduleHeight', 
		                     'moduleWidth',
							 'blockPosition',
							 'customBlockPosition',
							 'blockDisplay',
							 'enable_jquery',
							 'menuAssignment',
							 'folder', 
							 'imagecategory', 
							 'startItem', 
							 'mainWidth', 
							 'mainHeight', 
							 'showdesc', 
							 'showdescwhen',
							 'readmoretext', 
							 'duration', 
							 'animation', 
							 'navigationAlignment',
							 'navigation',
							 'thumbWidth', 
							 'thumbHeight', 
							 'thumbSpace', 
							 'showItem', 
							 'control', 
							 'autoplay', 
							 'interval', 
							 'thumbOpacity', 
							 'descOpacity', 
							 //'overlapOpacity', 
							 'description' ,
							  'thumbnailMode',
							 'useRatio',
							 'useRatios',
							 'source',
							 'sourceProductsMode',
							 'catsid',
							 'quanlity',
							 'navItemHeight',
							 'navItemWidth',
							 
		);
		
		
		foreach ($arrayParams as $var)
		{	    	
			$tags = array('lof_slider', 'slider_source','image_source_setting','catalog_source_setting', 'main_slider', 'navigation', 'thumbnail','file_source_setting', 'animation', 'description_setting');
			foreach($tags as $tag){
				if(Mage::getStoreConfig("lof_slider/$tag/$var")!=""){
					$data[$var] =  Mage::getStoreConfig("lof_slider/$tag/$var");
				}
			}
			if(isset($attributes[$var]))
			{
				$data[$var] =  $attributes[$var];
			}	
		}
    	return $data;
	}	  
	    public function getImageUrl($url = null) {
        return Mage::getSingleton('lof_slider/config')->getBaseMediaUrl() . $url;
    }

    /**
     * Encode the mixed $valueToEncode into the JSON format
     *
     * @param mixed $valueToEncode
     * @param  boolean $cycleCheck Optional; whether or not to check for object recursion; off by default
     * @param  array $options Additional options used during encoding
     * @return string
     */
    public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array())
    {
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
}
?>