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
 * @category    Lof
 * @package     Lof_Slider
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Lof Slide Model Observer
 *
 * @category    Lof
 * @package     Lof_Slider
 * @author    LandOfCoder (landofcoder@gmail.com)
 */
class Lof_Slider_Model_Observer
{
   public function beforeRender( Varien_Event_Observer $observer ){
		$this->_loadMedia();
   }
   function _loadMedia( $config = array()){
   
		if( Mage::getStoreConfig("lof_slider/lof_slider/show") ) { 
			$mediaHelper = Mage::helper("lof_slider/media");
			if(  Mage::getStoreConfig("lof_slider/lof_slider/enable_jquery")  ){	
				$mediaHelper->addMediaFile("js","lof_slider/jquery.js");
			}
			$mediaHelper->addMediaFile("js","lof_slider/jquery.easing.js");
			$mediaHelper->addMediaFile("js",'lof_slider/script.js');
		}
	}
}
