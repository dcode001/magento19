<?php

class Lof_Slider_Model_System_Config_Source_ListNavigationAlignment
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'horizontal', 'label'=>Mage::helper('lof_slider')->__('Horizontal')),
            array('value'=>'vertical', 'label'=>Mage::helper('lof_slider')->__('Vertical')),
            array('value'=>'0', 'label'=>Mage::helper('lof_slider')->__('Disable'))
        );
    }    
}
