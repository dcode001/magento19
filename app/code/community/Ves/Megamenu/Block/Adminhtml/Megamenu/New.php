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
class Ves_Megamenu_Block_Adminhtml_Megamenu_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
    
        $this->_objectId = 'id';
        $this->_blockGroup = 'ves_megamenu';
        $this->_controller = 'adminhtml_megamenu';
        
        //$this->_updateButton('save', 'label', Mage::helper('megamenu')->__('Continue'));
        $this->_removeButton('reset');
        $this->_removeButton('save');
    }
    
    public function getHeaderText()
    {
        return Mage::helper('ves_megamenu')->__('Add Megamenu');
    }
    
    public function getFormHtml()
    {
        return $this->getLayout()->getBlock('ves_megamenu.type')->toHtml();
    }
}