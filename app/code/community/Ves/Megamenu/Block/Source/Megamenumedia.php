<?php
/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
if (!class_exists("Ves_Megamenu_Block_List")) {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "List.php";
}

class Ves_Megamenu_Block_Source_Megamenumedia extends Ves_Megamenu_Block_List {

    function _toHtml() {
        $this->_config['template'] = 'ves/megamenu/initjs.phtml';
        // render html
	   $this->assign('config', $this->_config);
        $this->setTemplate($this->_config['template']);
        return parent::_toHtml();
    }
}
