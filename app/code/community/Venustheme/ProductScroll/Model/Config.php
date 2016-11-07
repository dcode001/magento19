<?php
class Venustheme_ProductScroll_Model_Config extends Mage_Catalog_Model_Product_Media_Config {

    public function getBaseMediaPath() {
        return Mage::getBaseDir('media') .DS. 'productscroll';
    }

    public function getBaseMediaUrl() {
        return Mage::getBaseUrl('media') . 'productscroll';
    }

    public function getBaseTmpMediaPath() {
        return Mage::getBaseDir('media') .DS. 'tmp' .DS. 'productscroll';
    }

    public function getBaseTmpMediaUrl() {
        return Mage::getBaseUrl('media') . 'tmp/productscroll';
    }

}