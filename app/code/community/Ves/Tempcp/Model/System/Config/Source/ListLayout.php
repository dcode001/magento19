<?php

class Ves_Tempcp_Model_System_Config_Source_ListLayout {

    public function toOptionArray() {
        return array(
            array('value' => 'col-lcr', 'label' => Mage::helper('ves_tempcp')->__('Content-Right')),
            array('value' => 'col-rcl', 'label' => Mage::helper('ves_tempcp')->__('Right-Content'))
            //array('value' => 'col-crl', 'label' => Mage::helper('ves_tempcp')->__('Content - Right - Left'))
        );
    }

}
