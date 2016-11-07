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
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Renderer for lable in fieldset
 *
 * @author LandOfCoder <landofcoder@gmail.com>
 */
class Lof_Slider_Block_System_Config_Form_Field_Information  extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
	public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $useContainerId = $element->getData('use_container_id');
        return sprintf('<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5" class="lof-description">
					   <h3>	<a href="http://landofcoder"><b>Magento - Lof Slider Block</b></a>  </h3>
							The most elegant way to show list products of your prestashop store inside the smooth Sideshow. the module supports multiple themes for fitting your design, easy to make owner themes by yourself,  and many kind of selecting products sources.  When you used, sure you will get highest effects while introducing your customers great products, featured products .<br><br>
							
							<h4><b>Guide</b></h4>
							<ul>
								<li><a href=""> 1) Forum Support</a></li>
								<li><a href=""> 2) Submit A Request</a></li>
								<li><a href=""> 3) Submit A Ticket</a></li>
							</ul>
							<br>
							<div style="font-size:11px">@Copyright: <i><a href="http://landofcoder.com" target="_blank">LandOfCoder.Com</a></i></div>
					   </td></tr>',
            $element->getHtmlId(), $element->getHtmlId(), $element->getLabel()
        );
    }
}
?>