<?php


class Venustheme_ProductScroll_Block_Adminhtml_Banner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $_model = Mage::registry('banner_data');
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('venustheme_productscroll')->__('General Information')));
        
		
		$fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Is Active'),
            'name'      => 'is_active',
            'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            //'value'     => $_model->getIsActive()
        ));
		$fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
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
            //'value'     => $_model->getLabel()
        ));

		$fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Link'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'link',
			//'value'     => $_model->getLink()
        ));
		
		$fieldset->addField('position', 'text', array(
            'label'     => Mage::helper('venustheme_productscroll')->__('Position'),
            'class'     => 'required-entry',
            'required'  => false,
            'name'      => 'position',
			//'value'     => $_model->getPosition()
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
		

        
		

        /*if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('stores', 'multiselect', array(
                'label'     => Mage::helper('venustheme_productscroll')->__('Visible In'),
                'required'  => true,
                'name'      => 'stores[]',
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
                'value'     => $_model->getStoreId()
            ));
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
        }*/


        //if( Mage::getSingleton('adminhtml/session')->getBannerData() ) {
         //   $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
         //   Mage::getSingleton('adminhtml/session')->setBannerData(null);
        //}
		
		if ( Mage::getSingleton('adminhtml/session')->getBannerData() )
		  {
			  $form->setValues(Mage::getSingleton('adminhtml/session')->getBannerData());
			  Mage::getSingleton('adminhtml/session')->getBannerData(null);
		  } elseif ( Mage::registry('banner_data') ) {
			  $form->setValues(Mage::registry('banner_data')->getData());
		  }
        
        return parent::_prepareForm();
    }
}
