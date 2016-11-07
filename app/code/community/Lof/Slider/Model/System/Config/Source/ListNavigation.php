<?php


class Lof_Slider_Model_System_Config_Source_ListNavigation
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('lof_slider')->__('No')),
            array('value'=>'number', 'label'=>Mage::helper('lof_slider')->__('Number')),
            array('value'=>'thumbs', 'label'=>Mage::helper('lof_slider')->__('Thumbnails'))
        );
    }    
}
