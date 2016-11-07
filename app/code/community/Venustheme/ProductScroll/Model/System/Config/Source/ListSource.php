<?php


class Venustheme_ProductScroll_Model_System_Config_Source_ListSource
{	

	private function _listDirectories($path, $fullPath = false)
    {
        $result = array();
        $dir = opendir($path);
        if ($dir) {
            while ($entry = readdir($dir)) {
                if (substr($entry, 0, 1) == '.' || !is_file($path . DS . $entry)){
                    continue;
                }
   				if( preg_match("/.php/",$entry) ){
                	$result[] = str_replace( ".php","",$entry);
				}
            }
            unset($entry);
            closedir($dir);
        }

        return $result;
    }
	
    public function toOptionArray()
    {
		$directory = Mage::getBaseDir('code') . DS . 'community' . DS . 'Venustheme' . DS . 'ProductScroll' .  DS . 'Block'.  DS . 'Source';
		
		
        $files = $this->_listDirectories($directory);
		$output = array();
		foreach( $files as $file ){
			$output[] = array('value'=>strtolower($file), 'label'=>Mage::helper('venustheme_productscroll')->__($file));
		}
        return $output ;
    }    
}
