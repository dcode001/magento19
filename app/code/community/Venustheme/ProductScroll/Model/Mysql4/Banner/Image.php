<?php

class Venustheme_ProductScroll_Model_Mysql4_Banner_Image extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('venustheme_productscroll/banner_image', 'banner_image_id');
    }
}