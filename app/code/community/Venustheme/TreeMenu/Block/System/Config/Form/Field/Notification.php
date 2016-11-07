<?php

class Venustheme_TreeMenu_Block_System_Config_Form_Field_Notification extends Mage_Adminhtml_Block_System_Config_Form_Field {

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) {
        $time = intval($element->getValue());
        $time = !empty($time) ? $time : time();
        $url = Mage::getBaseUrl('js');
        $jspath = $url . 'venustheme_treemenu/form/script.js';
        $csspath = $url . 'venustheme_treemenu/form/style.css';
        $output = '<link rel="stylesheet" type="text/css" href="' . $csspath . '" />';
		
		$output .= '<script type="text/javascript" src="' . $url .'venustheme_treemenu/jquery.js'. '"></script>';
		
		$output .= '<script type="text/javascript" src="' . $url .'venustheme_treemenu/form/jpicker-1.1.6.min.js'. '"></script>';
		
        $output .= '<script type="text/javascript" src="' . $jspath . '"></script>';
        $format = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $timeUpdate = Mage::app()->getLocale()->date()->toString($format);

		$color = $url. 'venustheme_treemenu/form/images/';
		$colorPath = '<script type="text/javascript"> var colorImgPath = \''.$color.'\'; </script>';
        return $timeUpdate . $colorPath .$output;
    }

}

?>