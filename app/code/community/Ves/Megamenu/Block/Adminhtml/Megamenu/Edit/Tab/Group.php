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
class Ves_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Group extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('ves_megamenu_relation_group');
        $this->setDefaultSort('ves_megamenu_group_id');
        $this->setDefaultDir('ASC');
        //$this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if (Mage::registry('megamenu_data')->getId()) {
            $this->setDefaultFilter(array('in_groups'=>1));
        }
    }
  
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ves_megamenu/group')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_groups') {
            $groupIds = $this->getSelectedGroup();
            if (empty($groupIds)) {
                $groupIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('ves_megamenu_group_id', array('in'=>$groupIds));
            } else {
                if($groupIds) {
                    $this->getCollection()->addFieldToFilter('ves_megamenu_group_id', array('nin'=>$groupIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
  
    protected function _prepareColumns()
    {
        $this->addColumn('in_groups', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'in_groups',
            'values'            => $this->getSelectedGroup(),
            'align'             => 'center',
            'index'             => 'ves_megamenu_group_id'
        ));
        
        $this->addColumn('ves_megamenu_group_id', array(
            'header'    => Mage::helper('ves_megamenu')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'ves_megamenu_group_id',
        ));
  
        $this->addColumn('title', array(
            'header'    => Mage::helper('ves_megamenu')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
        
        $this->addColumn('is_root', array(
            'header'    => Mage::helper('ves_megamenu')->__('Is Root Group'),
            'align'     => 'left',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Yes',
                2 => 'No',
            ),
        ));
        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header'        => Mage::helper('ves_megamenu')->__('Store View'),
                'index'         => 'stores',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }
  
        $this->addColumn('sort_order', array(
            'header'    => Mage::helper('ves_megamenu')->__('Sort Order'),
            'align'     =>'left',
            'index'     => 'sort_order',
        ));
  
        $this->addColumn('status', array(
            'header'    => Mage::helper('ves_megamenu')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));
        
        return parent::_prepareColumns();
    }
    
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
  
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
  
        $this->getCollection()->addStoreFilter($value);
    }
    
    public function getGridUrl()
    {
        return $this->getData('grid_url')
            ? $this->getData('grid_url')
            : $this->getUrl('*/*/groupsGrid', array('_current'=>true));
    }
    
    public function getSelectedGroup() {
        $selectedValue = array();
        $groups = Mage::registry('megamenu_data')->getGroups();
        foreach($groups as $group) {
            $selectedValue[] = $group['ves_megamenu_group_id'];
        }
        return $selectedValue;
    }
}