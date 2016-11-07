<?php
/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?phpclass Ves_Megamenu_Block_Adminhtml_Megamenu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  { 
      parent::__construct();	
      $this->setId('megamenuGrid');
      $this->setDefaultSort('ves_megamenu_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);	 $this->setTemplate('ves_megamenu/megamenu/banner.phtml');
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('ves_megamenu/megamenu')->getCollection();
      $this->setCollection($collection);		
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {	

      $this->addColumn('ves_megamenu_id', array(
          'header'    => Mage::helper('ves_megamenu')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'ves_megamenu_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('ves_megamenu')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
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
	  
	  $this->addColumn('action',
		  array(
			  'header'    =>  Mage::helper('ves_megamenu')->__('Action'),
			  'width'     => '100',
			  'type'      => 'action',
			  'getter'    => 'getId',
			  'actions'   => array(
				  array(
					  'caption'   => Mage::helper('ves_megamenu')->__('Edit'),
					  'url'       => array('base'=> '*/*/edit'),
					  'field'     => 'id'
				  )
			  ),
			  'filter'    => false,
			  'sortable'  => false,
			  'index'     => 'stores',
			  'is_system' => true,
	  ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('ves_megamenu')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('ves_megamenu')->__('XML'));
	  
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

  protected function _prepareMassaction()
  {
	  $this->setMassactionIdField('ves_megamenu_id');
	  $this->getMassactionBlock()->setFormFieldName('megamenu');

	  $this->getMassactionBlock()->addItem('delete', array(
		   'label'    => Mage::helper('ves_megamenu')->__('Delete'),
		   'url'      => $this->getUrl('*/*/massDelete'),
		   'confirm'  => Mage::helper('ves_megamenu')->__('Are you sure?')
	  ));

	  $statuses = Mage::getSingleton('ves_megamenu/status')->getOptionArray();

	  array_unshift($statuses, array('label'=>'', 'value'=>''));
	  $this->getMassactionBlock()->addItem('status', array(
		   'label'=> Mage::helper('ves_megamenu')->__('Change status'),
		   'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
		   'additional' => array(
				  'visibility' => array(
					   'name' => 'status',
					   'type' => 'select',
					   'class' => 'required-entry',
					   'label' => Mage::helper('ves_megamenu')->__('Status'),
					   'values' => $statuses
				   )
		   )
	  ));
	  return $this;
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}