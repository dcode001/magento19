<?php

class Venustheme_Brand_Model_System_Config_Source_ListSourceType
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'latest', 'label'=>Mage::helper('venustheme_brand')->__('Latest Brands') ),
            array('value'=>'hit', 'label'=>Mage::helper('venustheme_brand')->__('Most Read') ),

        );
    }    
}
