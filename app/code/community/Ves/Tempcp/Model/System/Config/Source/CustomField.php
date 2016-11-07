<?php

class Ves_Tempcp_Model_System_Config_Source_CustomField extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $value = $element->getValue();
        $element->setStyle('width:70px;')
                ->setType('hidden');
        $inputHidden = $element->setValue(isset($value) ? $value : 'pattern10')->getElementHtml();

		$skinDir = str_replace('adminhtml'.DS,'',Mage::getSingleton('core/design_package')->getSkinBaseDir(array('_package' => 'frontend\default')));
		$index = strrpos($skinDir, DS);
		$theme = substr($skinDir,$index + 1);
		
 
		$baseURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/default/' . $theme . '/images/patterns/';
		
        $html = '<div class="bgpattern">';
        $html .= $inputHidden;

        $helper = Mage::helper('ves_tempcp/data');
        $data = $helper->getThemeInfo(1);
		
//		echo "<br/>";
//		var_dump($data); die;
		
        $patterns = $data['patterns'];
        
        foreach ($patterns as $p) {
            $html .='<div style="background:url(\'' . $baseURL . $p . '\');" onclick="return false;" href="#" title="' . $p . '" id="' . preg_replace("#\.\w+$#", "", $p) . '"></div>';
        }

        $html .= '</div>';
        return $html;
    }

}

?>