<?php

class Lof_Slider_Model_System_Config_Source_ListTypeShowDescwhen
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'always', 'label'=>Mage::helper('lof_slider')->__('Always')),
            array('value'=>'mouseover', 'label'=>Mage::helper('lof_slider')->__('Mouse Over Image'))
        );
    }    
}
