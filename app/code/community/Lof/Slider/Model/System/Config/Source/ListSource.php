<?php


class Lof_Slider_Model_System_Config_Source_ListSource
{	

	 
	
    public function toOptionArray()
    {
		 return array(
        	 
            array('value'=>'image', 'label'=>Mage::helper('lof_slider')->__('Image Folder')),
            array('value'=>'catalog', 'label'=>Mage::helper('lof_slider')->__('Catalog')),
            array('value'=>'file', 'label'=>Mage::helper('lof_slider')->__('Files Banner'))
        );
    }    
}
