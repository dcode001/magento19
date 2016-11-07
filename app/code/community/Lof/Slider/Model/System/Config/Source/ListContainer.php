<?php


class Lof_Slider_Model_System_Config_Source_ListContainer
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'0', 'label'=>Mage::helper('lof_slider')->__('Fit to main image')),
            array('value'=>'1', 'label'=>Mage::helper('lof_slider')->__('Full size'))
        );
    }    
}
