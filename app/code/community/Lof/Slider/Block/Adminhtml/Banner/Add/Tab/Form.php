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
 * General form
 *
 * @category   Lof
 * @package     Lof_Slider
 * @author    
 */

class Lof_Slider_Block_Adminhtml_Banner_Add_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('lof_slider')->__('General Information')));
       
		$fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('lof_slider')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
		
		$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('lof_slider')->__('Enable'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'is_active',
			'values' 	  =>array('0'=>'No', '1'=>'Yes')
        ));
		
		$fieldset->addField('file', 'image', array(
            'label'     => Mage::helper('lof_slider')->__('Image'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'file',
        ));
		
		$fieldset->addField('label', 'text', array(
            'label'     => Mage::helper('lof_slider')->__('Group'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'label',
        ));
		
		$fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('lof_slider')->__('Link'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'link',
        ));
		
		$fieldset->addField('position', 'text', array(
            'label'     => Mage::helper('lof_slider')->__('Position'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'position',
        ));
		
		$fieldset->addField('description', 'editor', array(
            'label'     => Mage::helper('lof_slider')->__('Description'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'description',
			'style'     => 'width:600px;height:300px;',
            'wysiwyg'   => false,
			//'config'    => Mage::getVersion() > '1.4' ? @Mage::getSingleton('cms/wysiwyg_config')->getConfig() : false,
        ));
		
		
		
		
        
        return parent::_prepareForm();
    }
}
