<?php

class Lof_Slider_Model_System_Config_Source_ListTypeShowDesc
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('lof_slider')->__('No Description')),
            array('value'=>'desc', 'label'=>Mage::helper('lof_slider')->__('Description only')),
            array('value'=>'desc-readmore', 'label'=>Mage::helper('lof_slider')->__('Description with Readmore'))
        );
    }    
}
