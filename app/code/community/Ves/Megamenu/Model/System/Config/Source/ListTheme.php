<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Lof * @package     ves_megamenu
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Position config model
 *
 * @category   Lof
 * @package     ves_megamenu
 * @author    
 */
class Ves_Megamenu_Model_System_Config_Source_ListTheme
{
	private function _listDirectories($path, $fullPath = false)
    {
        $result = array();
        $dir = opendir($path);
        if ($dir) {
            while ($entry = readdir($dir)) {
                if (substr($entry, 0, 1) == '.' || !is_dir($path . DS . $entry)){
                    continue;
                }
                if ($fullPath) {
                    $entry = $path . DS . $entry;
                }
                $result[] = $entry;
            }
            unset($entry);
            closedir($dir);
        }

        return $result;
    }
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {

		//$directory = Mage::getBaseDir('design') . DS . 'frontend' . DS . $package;
		$directory = Mage::getBaseDir('skin') . DS . 'frontend' . DS . 'default' . DS . 'default' .  DS . 'ves_megamenu';
        $directories = $this->_listDirectories($directory);
        $templates =  array();
		foreach($directories as $key => $template){
			$templates[] = array('value' => $template, 'label'=>$template);
		}
		
		return $templates;
    }
}