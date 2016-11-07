<?php

class Venustheme_ProductScroll_Model_System_Config_Source_ListType
{
    public function toOptionArray()
    {
        return array(
        	array('value'=>'', 'label'=>Mage::helper('venustheme_productscroll')->__('-- Please select --')),
            array('value'=>'latest', 'label'=>Mage::helper('venustheme_productscroll')->__('Latest')),
            array('value'=>'best_buy', 'label'=>Mage::helper('venustheme_productscroll')->__('Best Buy')),
            array('value'=>'most_viewed', 'label'=>Mage::helper('venustheme_productscroll')->__('Most Viewed')),
            array('value'=>'most_reviewed', 'label'=>Mage::helper('venustheme_productscroll')->__('Most Reviewed')),
            array('value'=>'top_rated', 'label'=>Mage::helper('venustheme_productscroll')->__('Top Rated')),
            array('value'=>'attribute', 'label'=>Mage::helper('venustheme_productscroll')->__('Featured Product'))
        );
    }    
}
