<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Lof
 * @package     Lof_Slider
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Banner base block
 *
 * @category    Lof
 * @package     Lof_Slider
 * @author    LandOfCoder (landofcoder@gmail.com)
 */
class Lof_Slider_Block_Catalog extends Lof_Slider_Block_List 
{
	/**
     * Rendering block content
     *
     * @return string
     */
	function _toHtml() 
	{
		
		/*Verify*/
		if( !$this->_show || !$this->getConfig('show') ) return;
		$theme = ($this->getConfig('theme')!="") ? $this->getConfig('theme') : "default";
 		
		
		$list = $this->getListProducts ();
		$items = $list->getItems();
	 
		
		$this->assign( 'items', $items );
		$theme = ($this->getConfig('theme')!="") ? $this->getConfig('theme') : "default";
		$this->_config['template'] = 'lof/slider/'.$theme.'/list_products.phtml';	

		// render html
		$this->assign('config', $this->_config);
		$this->setTemplate($this->_config['template']);			
		return parent::_toHtml();
	}			

	function getListProducts() {
		$listall = null;
		
		switch ( $this->getConfig('sourceProductsMode') ) {
			case 'latest' :
				$listall = $this->getListBestBuyProducts ( 'updated_at', 'desc' );
				break;
			case 'feature' :
				break;
			case 'best_buy' :
				$listall = $this->getListBestBuyProducts ();
				break;
			case 'most_viewed' :
				$listall = $this->getListMostViewedProducts ();
				break;
			case 'most_reviewed' :
				$listall = $this->getListTopRatedProducts ( 'reviews_count' );
				break;
			case 'top_rated' :
				$listall = $this->getListTopRatedProducts ();
				break;
			case 'attribute' :
				$listall = $this->getListFeaturedProduct ();
				break;
		}
		
		return $listall;
	}
	
	function getListTopRatedProducts($orderfeild = 'rating_summary', $order = 'desc', $perPage = NULL, $currentPage = 1) {
		$list = null;
		if ($perPage === NULL)
			$perPage = ( int ) $this->getConfig( 'quanlity' );
		
        $storeId = Mage::app ()->getStore ()->getId ();
		
		$entityCondition = '_reviewed_order_table.entity_id = e.entity_id';
		
        if($this->_config['catsid']){
            // get array product_id
            $arr_productids = $this->getProductByCategory();    
            
		    $products = Mage::getResourceModel ( 'catalog/product_collection' )->setStoreId ( $storeId )->addAttributeToSelect ( '*' )->addStoreFilter ( $storeId )->addIdFilter($arr_productids);
        }else{
            $products = Mage::getResourceModel ( 'catalog/product_collection' )->setStoreId ( $storeId )->addAttributeToSelect ( '*' )->addStoreFilter ( $storeId );
        }    
		
		$products->getSelect ()->joinLeft ( array ('_reviewed_order_table' => $products->getTable ( 'review_entity_summary' ) ), "_reviewed_order_table.store_id=$storeId AND _reviewed_order_table.entity_pk_value=e.entity_id", array () );
		
		$products->getSelect ()->order ( "_reviewed_order_table.$orderfeild $order" );
		$products->getSelect ()->group ( 'e.entity_id' );
		
		$products->setPageSize ( $perPage )->setCurPage ( $currentPage );
		
		$this->setProductCollection ( $products );
        
        $this->_addProductAttributesAndPrices($products);
		
		if (($_products = $this->getProductCollection ()) && $_products->getSize ()) {
			$list = $products;
		}
		
		return $list;
	}
	
	function getListMostViewedProducts($perPage = NULL, $currentPage = 1) {
		/* 
			Always set de $perPage, by template or by config 
			if $perPage eq 0 (zero) not limit the list
		*/
		if ($perPage === NULL)
			$perPage = ( int ) $this->getConfig( 'quanlity' );
		
        /*
			Show all the product list in the current store			
		*/
		$storeId = Mage::app ()->getStore ()->getStoreId ();
		$this->setStoreId ( $storeId );
		
        if($this->_config['catsid']){
            // get array product_id
            $arr_productids = $this->getProductByCategory();    
            
		    $this->_productCollection = Mage::getResourceModel ( 'reports/product_collection' )->addIdFilter($arr_productids);
        }else{
            $this->_productCollection = Mage::getResourceModel ( 'reports/product_collection' );
        }    
		
		$this->_productCollection = $this->_productCollection->addViewsCount ();
		
		$this->_productCollection = $this->_productCollection->addAttributeToSelect ( '*' )->setStoreId ( $storeId )->addStoreFilter ( $storeId )->setPageSize ( $perPage );
        
        $this->_addProductAttributesAndPrices($this->_productCollection);
        
		return $this->_productCollection;
	}
	
	function getListBestBuyProducts($fieldorder = 'ordered_qty', $order = 'desc', $product_ids = '', $perPage = NULL, $currentPage = 1) {
		$list = null;
		/* 
			Always set de $perPage, by template or by config 
			if $perPage eq 0 (zero) not limit the list
		*/
		if ($perPage === NULL)
			$perPage = ( int ) $this->getConfig( 'quanlity' );
		/*
			Show all the product list in the current store
			order by ordered_qty, showing the bestsellers first
		*/
    
		$storeId = Mage::app ()->getStore ()->getId ();
		
        if($this->_config['catsid']){   
            // get array product_id
            $arr_productids = $this->getProductByCategory();    

            $products = Mage::getResourceModel ( 'catalog/product_collection' )
                        ->setStoreId ( $storeId )
                        ->addAttributeToSelect ( '*' )
                        ->addStoreFilter ( $storeId )
                        ->setOrder ( $fieldorder, $order )
                        ->addIdFilter($arr_productids)
                        ;
				
        }else{
            $products = Mage::getResourceModel ( 'catalog/product_collection' )->setStoreId ( $storeId )->addAttributeToSelect ( '*' )->addStoreFilter ( $storeId )->setOrder ( $fieldorder, $order );
        }        
        
              
		/*
			Filter list of product showing only the active and 
			visible product
		*/
		Mage::getSingleton ( 'catalog/product_visibility' )->addVisibleInCatalogFilterToCollection ( $products );
		Mage::getSingleton ( 'catalog/product_status' )->addVisibleFilterToCollection ( $products );
		
		$products->setPageSize ( $perPage )->setCurPage ( $currentPage );
		            
		$this->setProductCollection ( $products );
        
        $this->_addProductAttributesAndPrices($products);
		                  
		if (($_products = $this->getProductCollection ()) && $_products->getSize ()) {            
			$list = $_products;
		}
		
        
        
		return $list;
	}
	
	function getListFeaturedProduct() {
		
		$list = array ();
		// instantiate database connection object
		

		$resource = Mage::getSingleton ( 'core/resource' );
		
		$read = $resource->getConnection ( 'catalog_read' );
		
		$categoryProductTable = $resource->getTableName ( 'catalog/category_product' );
		
		$productEntityIntTable = ( string ) Mage::getConfig ()->getTablePrefix () . 'catalog_product_entity_int';
		
		$eavAttributeTable = $resource->getTableName ( 'eav/attribute' );
		
		// Query database for featured product        
		$select = $read->select ( 'cp.product_id' )
				->from ( array ('cp' => $categoryProductTable ) )
				->join ( array ('pei' => $productEntityIntTable ), 'pei.entity_id=cp.product_id', array () )
				->joinNatural ( array ('ea' => $eavAttributeTable ) )
				->where ( "pei.value='1'" )
				->where ( "ea.attribute_code='featured'" );

		$rows = $read->fetchAll ( $select );
		
		$product_ids = array ();
		if ($rows) {
			foreach ( $rows as $row ) {
				$product_ids [] = $row ['product_id'];
			}
			$product_ids = implode ( ',', $product_ids );
			$list = $this->getListBestBuyProducts ( 'updated_at', 'desc', $product_ids );
		}
		
		return $list;
	}
	function inArray($source, $target) {
		for($j = 0; $j < sizeof ( $source ); $j ++) {
			if (in_array ( $source [$j], $target )) {
				return true;
			}
		}
	}
    function getProductByCategory(){
        $return = array(); 
        $pids = array();
  
        $products = Mage::getResourceModel ( 'catalog/product_collection' );
         
        foreach ($products->getItems() as $key => $_product){
		
            $arr_categoryids[$key] = $_product->getCategoryIds();
            
            if($this->_config['catsid']){    
                if(stristr($this->_config['catsid'], ',') === FALSE) {
                    $arr_catsid[$key] =  array(0 => $this->_config['catsid']);
                }else{
                    $arr_catsid[$key] = explode(",", $this->_config['catsid']);
                }
                
                $return[$key] = $this->inArray($arr_catsid[$key], $arr_categoryids[$key]);
            }
        }
        
        foreach ($return as $k => $v){ 
            if($v==1) $pids[] = $k;
        }    
        
        return $pids;   
    }
}
