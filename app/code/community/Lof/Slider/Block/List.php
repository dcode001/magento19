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
 * @category    Lof * @package     Lof_Slider
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog Block Image List
 *
 * @author      LandOfCoder <landofcoder@gmail.com>
 */
 
class Lof_Slider_Block_List extends Mage_Catalog_Block_Product_Abstract 
{
	/**
	 * @var string $_config
	 * 
	 * @access protected
	 */
	protected $_config = '';
	
	/**
	 * @var string $_config
	 * 
	 * @access protected
	 */
	protected $_listDesc = array();
	
	/**
	 * @var string $_config
	 * 
	 * @access protected
	 */
	protected $_show = 0;
	protected $_theme = "";
	
	/**
	 * Contructor
	 */
	public function __construct($attributes = array())
	{
		$helper =  Mage::helper('lof_slider/data');
		$this->_config = $helper->get($attributes);
		$this->_show = $this->getConfig("show");
		if(!$this->_show) return;
		/*End init meida files*/
		$mediaHelper =  Mage::helper('lof_slider/media');
		$this->_theme = $this->getConfig("theme");
		$mediaHelper->addMediaFile("skin_css", "lof_slider/".$this->_theme."/style.css" );
		parent::__construct();		
	}
	/**
	 * get value of the extension's configuration
	 *
	 * @return string
	 */
	function getConfig( $key ){
		return $this->_config[$key];
	}
	
	/**
	 * overrde the value of the extension's configuration
	 *
	 * @return string
	 */
	function setConfig( $key, $value ){
		$this->_config[$key] = $value;
		return $this;
	}	
 	
  	/**
	 *
	 */
    function parseParams($params) {
    	$params = html_entity_decode($params, ENT_QUOTES);
        $regex = "/\s*([^=\s]+)\s*=\s*('([^']*)'|\"([^\"]*)\"|([^\s]*))/";
        preg_match_all($regex, $params, $matches);
        $paramarray = null;
        if(count($matches)){
        $paramarray = array();
        	for ($i=0;$i<count($matches[1]);$i++){ 
            	$key = $matches[1][$i];
            	$val = $matches[3][$i]?$matches[3][$i]:($matches[4][$i]?$matches[4][$i]:$matches[5][$i]);
            	$paramarray[$key] = $val;
             }
        }
        return $paramarray;
    }   
	function isStaticBlock(){
		$name = isset($this->_config["name"])?$this->_config["name"]:"";
		if(!empty($name)){
			$regex1 = '/static_(\s*)/';
			if (preg_match_all($regex1,$name,$matches)){
				return true;
			}
		}
		return false;
	}
	function set($params){
		$params = preg_split ("/\n/", $params);
		foreach ($params as $param){	
			$param = trim($param);
			if (!$param) continue;
			$param = split ("=", $param, 2);
			if (count($param) == 2 && strlen(trim($param[1])) > 0)
				$this->_config[trim($param[0])] =  trim($param[1]);
		}
		$theme =  $this->getConfig("theme");
		if($theme != $this->_theme){
			$mediaHelper =  Mage::helper('lof_slider/media');
			$mediaHelper->addMediaFile("skin_css", "lof_slider/".$theme."/style.css" );
		}
	}
	
	/**
	 * render thumbnail image
	 */
	public function buildThumbnail ( $imageArray, $twidth, $theight ) {
		$thumbnailMode = $this->_config['thumbnailMode'];
		if( $thumbnailMode != 'none' ) {
			$imageProcessor =  Mage::helper('lof_slider/lofimage');
			$imageProcessor->setStoredFolder();
			foreach ($imageArray as $image) {
				$thumbs[]  = $imageProcessor->resize( $image,$twidth, $theight );
			}
			return $thumbs;
		} 
		return $imageArray;
	}
}
