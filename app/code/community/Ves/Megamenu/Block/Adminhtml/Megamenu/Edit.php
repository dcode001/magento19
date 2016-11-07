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
class Ves_Megamenu_Block_Adminhtml_Megamenu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
	$this->_blockGroup  = 'ves_megamenu';
        $this->_objectId    = 'ves_megamenu_id';
        $this->_controller  = 'adminhtml_megamenu';
        $this->_mode        = 'edit';

        parent::__construct();
		$this->setTemplate('ves_megamenu/megamenu/edit.phtml');
    }

    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
}