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
class Ves_Megamenu_Block_Adminhtml_Megamenu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('ves_megamenu_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('ves_megamenu')->__('Megamenu Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('ves_megamenu')->__('Megamenu Information'),
          'title'     => Mage::helper('ves_megamenu')->__('Megamenu Information'),
          'content'   => $this->getLayout()->createBlock('ves_megamenu/adminhtml_megamenu_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}