<?php
/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php
class Ves_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Link extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $_model = Mage::registry('megamenu_data');
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('link_form', array('legend'=>Mage::helper('ves_megamenu')->__('Megamenu Link')));
        $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('ves_megamenu')->__('Link'),
          'class'     => 'required-entry',
          'required'  => false,
          'name'      => 'ves_megamenu[link]',
          'class'     => 'validate-url',
          'value'     => $_model->getLink()
        ));
        
        $fieldset->addField('target', 'select', array(
          'label'     => Mage::helper('ves_megamenu')->__('Status'),
          'name'      => 'ves_megamenu[target]',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('ves_megamenu')->__('_self'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('ves_megamenu')->__('_blank'),
              ),
              
              array(
                    'value'   => 3,
                    'label'   => Mage::helper('ves_megamenu')->__('_parent')
              ),
              
              array(
                    'value'   => 4,
                    'label'   => Mage::helper('ves_megamenu')->__('_top')
              ),
          ),
          'value'   => $_model->getTarget()
      ));
        
        return parent::_prepareForm();
    }
}