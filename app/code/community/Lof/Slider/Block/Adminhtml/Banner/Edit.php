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
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Banner edit block
 *
 * @category   Lof
 * @package     Lof_Slider
 * @author    
 */

class Lof_Slider_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId    = 'id';
        $this->_blockGroup  = 'lof_slider';
        $this->_controller  = 'adminhtml_banner';

        $this->_updateButton('save', 'label', Mage::helper('lof_slider')->__('Save Banner'));
        $this->_updateButton('delete', 'label', Mage::helper('lof_slider')->__('Delete Banner'));

        //$this->_addButton('saveandcontinue', array(
        //    'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
        //    'onclick'   => 'saveAndContinueEdit()',
        //    'class'     => 'save',
        //), -100);

        //$this->_formScripts[] = "
       //     function saveAndContinueEdit(){
       //         editForm.submit($('edit_form').action+'back/edit/');
       //     }
       // ";
    }

    public function getHeaderText()
    {
        return Mage::helper('lof_slider')->__("Edit Banner '%s'", $this->htmlEscape(Mage::registry('banner_data')->getLabel()));
    }
}