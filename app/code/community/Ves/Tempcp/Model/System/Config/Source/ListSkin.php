<?php

class Ves_Tempcp_Model_System_Config_Source_ListSkin {

    public function toOptionArray() {
        $arr = array();
        $helper = Mage::helper('ves_tempcp/data');
        $data = $helper->getThemeInfo(1);
		
		//var_dump($data); die;
		
		
        if(!empty($data)){
            $skins = $data['skins'];
            foreach ($skins as $key => $value) {
                $tmp = array();
                $tmp['value'] = $value;
                $tmp['label'] = Mage::helper('ves_tempcp')->__($value);
                $arr[] = $tmp;
            }
        }
        return $arr;
    }
}