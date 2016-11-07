<?php

class Venustheme_ProductScroll_Block_Adminhtml_Banner_Add_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('venustheme_productscroll')->__('General Information')));
       
		$fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
		
		$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Enable'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'is_active',
			'values' 	  =>array('0'=>'No', '1'=>'Yes')
        ));
		
		$fieldset->addField('file', 'image', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Image'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'file',
        ));
		
		$fieldset->addField('label', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Group'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'label',
        ));
		
		$fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Link'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'link',
        ));
		
		$fieldset->addField('position', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Position'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'position',
        ));
		
		$fieldset->addField('price', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Price'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'price',
        ));
		
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$fieldset->addField('created_at', 'date', array(
            'name'   => 'created_at',
            'label'  => Mage::helper('venustheme_productscroll')->__('Date Add'),
            'title'  => Mage::helper('venustheme_productscroll')->__('Date Add'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => $dateFormatIso
        ));
		
		
		
		
		$fieldset->addField('description', 'editor', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Description'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'description',
			'style'     => 'width:600px;height:300px;',
            'wysiwyg'   => false,
			//'value'     => $_model->getDescription()
			//'config'    => Mage::getVersion() > '1.4' ? @Mage::getSingleton('cms/wysiwyg_config')->getConfig() : false,
        ));
        
        return parent::_prepareForm();
    }
}
