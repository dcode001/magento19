<?php

class Ves_Tempcp_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $skin = ($this->getRequest()->getParam('skin'));
        $layout = ($this->getRequest()->getParam('layout'));
        $bgpattern = $this->getRequest()->getParam('bgpattern');
        $usercustom = $this->getRequest()->getParam('usercustom');

        $helper = Mage::helper('ves_tempcp/data');
        $config = $helper->get();

        $paneltool = (empty($config['leopntool'])) ? 1 : 0;
        
        if ($paneltool) {
            $vars = array("skin" => $skin, "layout" => $layout, "bgpattern" => $bgpattern);
            if (strtolower($usercustom) == "apply") {
                foreach ($vars as $key => $val) {
                    $valitem = $this->getRequest()->getParam($key);
                    //echo $key . ':  ' . $valitem . "<br/>";
                    Mage::getModel('core/cookie')->set($key, $valitem);
                    //$val = $valitem;
                }
                $this->_redirectReferer();
            }

            if (strtolower($usercustom) == "reset") {
                foreach ($vars as $key => $val) {
                    Mage::getModel('core/cookie')->set($key, $config['leo' . $key]);
                }
                $this->_redirectReferer();
            }
        }
        $this->_redirectReferer();
    }

}

?>
