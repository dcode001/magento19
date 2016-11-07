<?php
 /*------------------------------------------------------------------------
  # VenusTheme Brand Module 
  # ------------------------------------------------------------------------
  # author:    VenusTheme.Com
  # copyright: Copyright (C) 2012 http://www.venustheme.com. All Rights Reserved.
  # @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  # Websites: http://www.venustheme.com
  # Technical Support:  http://www.venustheme.com/
-------------------------------------------------------------------------*/

class Venustheme_Brand_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup  = 'venustheme_brand';
        $this->_controller  = 'adminhtml_brand';

        $this->_updateButton('save', 'label', Mage::helper('venustheme_brand')->__('Save Record'));
        $this->_updateButton('delete', 'label', Mage::helper('venustheme_brand')->__('Delete Record'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('brand_data')->getId() ) {
			return Mage::helper('venustheme_brand')->__("Edit Record '%s'", $this->htmlEscape(Mage::registry('brand_data')->getTitle()));
		}else {
			return Mage::helper('venustheme_brand')->__("Add New Brand");
		}
	}
}