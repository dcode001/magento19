<?php
class Venustheme_ProductScroll_Block_Adminhtml_Banner_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
		
        parent::__construct();

        $this->_objectId    = 'id';
        $this->_blockGroup  = 'venustheme_productscroll';
        $this->_controller  = 'adminhtml_banner';

        $this->_updateButton('save', 'label', Mage::helper('venustheme_productscroll')->__('Save Record'));
		//$this->_addButton('saveandcontinue', array(
        //    'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
       //     'onclick'   => 'saveAndContinueEdit()',
       //     'class'     => 'save',
       // ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'content');
                }
            }

            
        ";
		//function saveAndContinueEdit(){
         //       editForm.submit($('edit_form').action+'back/edit/');
        //    }
    }

    public function getHeaderText()
    {
        Mage::helper('venustheme_productscroll')->__("Add Record");
    }
}