<?php
/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php
class Ves_Megamenu_Model_Megamenu extends Ves_Megamenu_Model_Abtract
{
	const TREE_ROOT_ID = 1;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('ves_megamenu/megamenu');
    }
    
    public function isActive() {
        if($this->getStatus() == Ves_Megamenu_Model_Status::STATUS_ENABLED) {
            return true;
        }
        return false;
    }
    
    public function hasChild($statusFilter = false, $storeId = null) {
        $collection = Mage::getModel('ves_megamenu/megamenu')->getCollection()
			->setStoreFilter($storeId)
			->addFieldToFilter('parent_id', $this->getId());
	if($statusFilter) {
		$collection->addStatusFilter();
	}
        if(count($collection))
            return true;
        return false;
    }
	
    public function getMegaMenus($id_megamenu = null, $active = false, $position_type = false, $parent_id = null){
		$where = ( $id_megamenu ? 'AND megamenu_id <> '.$id_megamenu : '').( $active ? ' AND status = 1' : '');
		
	
		if($position_type){
			//$where .= ' AND `position_type` = \''.$position_type.'\'';
		}
		$session = Mage::getSingleton('customer/session');
		$privacy = array(0,1);
		if($session->isLoggedIn()) {
			$privacy[] = 99;
			$privacy[]=$session->getCustomerGroupId();

						
		}
		
		$where .= ' AND privacy in('.implode(',',$privacy).') ';
	//	echo '<pre>'.print_r( $where, 1 ); die;
		if($parent_id !== null && $parent_id !== ""){
			$where .= " AND parent_id = ".$parent_id;
		}
		$tableName = Mage::getSingleton('core/resource')->getTableName('ves_megamenu_megamenu');
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$select = $connection->select()
							->from( $tableName , array('*'))		
							->where('1' . $where)               
							->group('megamenu_id')
                            ->order('position');
		$rowsArray = $connection->fetchAll($select);
		return $rowsArray;
	}
	public function getListProducts($values, $order_by_way = false, $limit = false){
		$result = array();
		$storeId = Mage::app ()->getStore ()->getId ();
		$id_categories = array();
		if( $values ){
			$id_categories = explode(',', $values);
		}
		if(!empty($id_categories)){
			$products = Mage::getResourceModel ( 'catalog/product_collection' )->setStoreId ( $storeId )->addAttributeToSelect ( '*' )->addStoreFilter ( $storeId )->addIdFilter($id_categories);
			if($order_by_way){
				$o = explode('-', $order_by_way);
				$order_by = $o[0];
				$order_way = $o[1];
			}
			if(isset($order_by) && isset($order_way)){
				$products->setOrder ( $order_by, $order_way );
			}
			$products->getSelect ()->group ( 'e.entity_id' );
			$products->setPageSize ( $limit )->setCurPage ( 0 );
			$result = $products;
		}
		return $result;
	}
	public function getListCategories($values, $order_by = false, $order_way = false){
		$result = array();
		$storeId = Mage::app ()->getStore ()->getId ();
		$id_categories = $values;
		if( $values && !is_array($values)){
			$id_categories = explode(',', $values);
			
		}
		if(!empty($id_categories)){
			$collection = Mage::getModel('catalog/category')->getCollection()
							->setStoreId($storeId)
							->addAttributeToSelect('*')
							->addIdFilter($id_categories);
			if($order_by && $order_way){
				$collection->setOrder( $order_by, $order_way);
			}
			$collection->getSelect ()->group ( 'e.entity_id' );
			$result = $collection;
		}
		
		return $result;
	}
	public function getListCMSs( $values ){
		$result = array();
		$id_cms = $values;
		if( $values && !is_array($values)){
			$id_cms = explode(',', $values);
		}
		
	
		$result = Mage::getModel('cms/page')->getCollection()
								->addFieldToFilter( 'page_id', array('in' => $id_cms))
								->addFieldToFilter('is_active', 1);
								
							
		return $result;
	}
	/**
	* get sub mega menu level 1
	*/
	public function getsubmegamenu($parent_id){
		$where = 'parent_id = '.$parent_id;
		$results = array();
		if($parent_id){
			$tableName = Mage::getSingleton('core/resource')->getTableName('ves_megamenu_megamenu');
			$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
			$select = $connection->select()
							->from($tableName, array('*'))
							->where($where)
                            ->order('position');
			$results = $connection->fetchAll($select);
		}
		return $results;
	}
    public function getChildItem($col=null, $storeId = null) {
        $collection = Mage::getModel('ves_megamenu/megamenu')->getCollection()
			->setStoreFilter($storeId)
			->addFieldToFilter('parent_id', $this->getId())
			->setOrder('position', 'ASC');
        if($col != null) {
            $collection->addFieldToFilter('col', $col);
        }
        return $collection;
    }
    
    public function isGroup() {
        if($this->getIsGroup() == 1) {
            return true;
        }
        return false;
    }
    
    public function showTitle() {
        if($this->getShowTitle() == 1) {
            return true;
        }
        return false;
    }
    
    public function isContent() {
        if($this->getIsContent() == 1) {
            return true;
        }
        return false;
    }
    
    public function isRoot() {
	if($this->getParentId() == 1)
	    return true;
	return false;
    }
    
    public function showSub() {
	if($this->getShowSub() == 1) {
		return true;
	}
	return false;
    }
    
    public function getRootId($storeId = null, $parentId=1) {
    	if($storeId == null)
    		$storeId = 0;
		$position_type = Mage::helper('ves_megamenu/data')->getPositionType();
    	$collection = $this->getCollection()
    				->setStoreFilter($storeId)
					/*->addFieldToFilter("position_type", $position_type)*/
    				->addFieldToFilter('parent_id', $parentId)
    				->addFieldToFilter('level_depth', 0);
    	$data = array();
    	foreach ($collection as $megamenu) {
    		$data[] = $megamenu->getId();
    	}
    	return $data;
    }
    
    public function renderTree($menu=null, $level=0, $activeId, $storeId = null)
    {
    	$html = '';

    	if(!$menu) {
			foreach($this->getRootId($storeId) as $rootId) {
				$menu = $this->load($rootId);
				$html .= $this->renderTree($menu, 0, $activeId, $storeId);
			}
			return $html;
    	}
    	
    	$html .= '<li id="'.$menu->getId().'" class="';
    	if($menu->isRoot() || $level==0) 
    	    $html .= 'root folder-open';
    	$html .= '"><span ';
		if($activeId == $menu->getId())
			$html .= 'class="active"';
		$html .= '>'.$menu->getTitle().'<span style="font-size:10px">( ID: '.$menu->getId().')</span></span>';
    	
    	if($menu->hasChild(false, $storeId)) {
			$html .= '<ul>';
			foreach ($menu->getChildItem(null, $storeId) as $child) {
				$html .= $this->renderTree($child, $level+1, $activeId, $storeId);
			}
			$html .= '</ul>';	
		}
			$html .= '</li>';
			
    	return $html;
    }
    
	public function renderDropdownMenu( $menu, $level=0,$activeID=0,$storeId=0 ){
		
		$html = '';
		if(!$menu) {
			$html = '<option value="0"> ROOT </option>';
			foreach($this->getRootId($storeId) as $rootId) {
				$menu = $this->load($rootId);
				$html .= $this->renderDropdownMenu($menu, 0, $activeID );
			}
			return $html;
    	}
		$selected = $menu->getId()==$activeID?'selected="selected"':"";
		$html = '<option '.$selected.' value="'.$menu->getId().'">'.str_repeat( "--",$level).$menu->getTitle().'(ID:'.$menu->getId().')'.'</option>';
		
		if($menu->hasChild(false, $storeId)) {
			foreach ($menu->getChildItem(null, $storeId) as $child) {
				$html .= $this->renderDropdownMenu( $child, $level+1, $activeID );
			}
		}
		return $html;
	}
	
    public function loadByCategoryId($categoryId)
    {
		return $this->getCollection()->addFieldToFilter('article', $categoryId)->getFirstItem();
    }
	public function load($megamenu_id = 0){
		return $this->getCollection()->addFieldToFilter('megamenu_id', $megamenu_id)->getFirstItem();
	}
}