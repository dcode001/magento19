<?php
/******************************************************
 * @package Venustheme Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://venustheme.com
 * @copyright	Copyright (C) December 2010 venustheme.com <@emai:venustheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
class Venustheme_TabHome_Model_ProductSource extends Venustheme_TabHome_Model_Abtract{

	 public function getListLatestProducts( $cateids=array(), $fieldorder = 'updated_at', $order = 'desc')
    {
    	$storeId    = Mage::app()->getStore()->getId();
   
    	if($cateids) {
    	    $arr_productids = $this->getProductByCategory();
	    $products = Mage::getResourceModel('catalog/product_collection')
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->addStoreFilter()
		    ->addIdFilter($arr_productids)
		    ->setOrder ($fieldorder,$order);
    	} else {
	    $products = Mage::getResourceModel('catalog/product_collection')
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addFinalPrice()
		    ->addStoreFilter()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->setOrder ($fieldorder,$order);
    	}		
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
	return $products;
    }
    
    public function getListBestSellerProducts($cateids=array(), $fieldorder = 'ordered_qty', $order = 'desc')
    {
    	$storeId    = Mage::app()->getStore()->getId();
  
    	if($cateids) {
    	    $arr_productids = $this->getProductByCategory();
    	    $products = Mage::getResourceModel('reports/product_collection')
			->addOrderedQty()
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()
			->addAttributeToSelect(array('name', 'price', 'small_image')) //edit to suit tastes
			->addIdFilter($arr_productids)// id product
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->setOrder ($fieldorder,$order);
    	} else {
	    $products = Mage::getResourceModel('reports/product_collection')
		    ->addOrderedQty()
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->addAttributeToSelect(array('name', 'price', 'small_image')) //edit to suit tastes
		    ->setStoreId($storeId)
		    ->addStoreFilter($storeId)
		    ->setOrder ($fieldorder,$order);
    	}
    			
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
	return $products;
    }
    
    public function getListMostViewedProducts()
    {
    	$storeId    = Mage::app()->getStore()->getId();
    	$cateids = $this->getConfig('catsid');
    	if($cateids) {
	    $arr_productids = $this->getProductByCategory();
	    $products = Mage::getResourceModel('reports/product_collection')
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()
			->addAttributeToSelect(array('name', 'price', 'small_image')) //edit to suit tastes            
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->addViewsCount()
			->addIdFilter($arr_productids);
    	} else {
    	    $products = Mage::getResourceModel('reports/product_collection')
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addUrlRewrite()
			->addTaxPercents()
			->addAttributeToSelect(array('name', 'price', 'small_image')) //edit to suit tastes
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->addViewsCount();
    	}
    			
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
	return $products;
    }
    
    public function getListFeaturedProducts()
    {
    	$storeId    = Mage::app()->getStore()->getId();
    	$cateids = $this->getConfig('catsid');
    	if($cateids) {
	    $arr_productids = $this->getProductByCategory();
	    $products = Mage::getResourceModel('catalog/product_collection')
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->addStoreFilter()
		    ->addIdFilter($arr_productids)
		    ->addAttributeToFilter("featured", 1);
	    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
	    Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($products);		
    	} else {
	    $products = Mage::getResourceModel('catalog/product_collection')
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->addStoreFilter()
		    ->addAttributeToFilter("featured", 1);
	    Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
	    Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($products);		
    	}
    	
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
	return $products;
    }
    
    public function getListNewProducts()
    {
    	$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	$storeId    = Mage::app()->getStore()->getId();
    	$cateids = $this->getConfig('catsid');
    	if($cateids) {
	    $arr_productids = $this->getProductByCategory();
		    $products = Mage::getResourceModel('catalog/product_collection')
			    ->addAttributeToSelect('*')
			    ->addMinimalPrice()
			    ->addUrlRewrite()
			    ->addTaxPercents()
			    ->addStoreFilter()
			    ->addIdFilter($arr_productids)
			    ->addAttributeToFilter('news_from_date', array('date'=>true, 'to'=> $todayDate))
			    ->addAttributeToFilter(array(array('attribute'=>'news_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'news_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
			    ->addAttributeToSort('news_from_date','desc');
    	} else {
	    $products = Mage::getResourceModel('catalog/product_collection')
		    ->addAttributeToSelect('*')
		    ->addMinimalPrice()
		    ->addUrlRewrite()
		    ->addTaxPercents()
		    ->addStoreFilter()
		    ->addAttributeToFilter('news_from_date', array('date'=>true, 'to'=> $todayDate))
		    ->addAttributeToFilter(array(array('attribute'=>'news_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'news_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
		    ->addAttributeToSort('news_from_date','desc');
    	}
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $products->setPageSize($this->getConfig('qty'))->setCurPage(1);
        $this->setProductCollection($products);
		return $products;
    }
}


?>