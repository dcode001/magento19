<?php


class Lof_Slider_Model_System_Config_Source_ListThumbnailMode
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'none', 'label'=>Mage::helper('lof_slider')->__('No')),
            array('value'=>'crop', 'label'=>Mage::helper('lof_slider')->__('Use Resizing Image'))
        );
    }    
}
