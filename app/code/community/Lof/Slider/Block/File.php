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
 * Catalog Block Image Source
 *
 * @author      LandOfCoder <landofcoder@gmail.com>
 */
class Lof_Slider_Block_File extends Lof_Slider_Block_List 
{
	function _toHtml() { 		 
		if( !$this->_show || !$this->getConfig('show') ) return;
		$theme = ($this->getConfig('theme')!="") ? $this->getConfig('theme') : "default";
		// check the source used ?
	 	$this->__renderSlideShowImagegroup();
		$this->assign('config', $this->_config);
		$this->setTemplate($this->_config['template']);				
        return parent::_toHtml();
	}
	/**
	 * render block content for the slideshow using the list of products.
	 */
	private function __renderSlideShowImagegroup() 
	{
		$_model = Mage::getModel('lof_slider/banner');
		$theme = ($this->getConfig('theme')!="") ? $this->getConfig('theme') : "default";
		$list = $_model	->getCollection()
						->addFieldToFilter('label', $this->_config['imagecategory'])
						->addFieldToFilter('is_active', 1)
						->setOrder('position', 'asc');
						
		
		$items = array();
		foreach($list as $item){
			$imageArray = array();
			$imageArray[] = 'media/'.$item->getFile();
			$itemArray = array();
			$mainImage = $this->buildThumbnail( $imageArray, $this->_config['mainWidth'], $this->_config['mainHeight'] );
			$thumbnail = $this->buildThumbnail( $imageArray, $this->_config['thumbWidth'], $this->_config['thumbHeight'] );
			$itemArray['mainImage'] = $mainImage[0];
			$itemArray['thumbnail'] = $thumbnail[0];
			$itemArray['title'] = $item->getTitle();
			$itemArray['link'] = $item->getLink();
			$itemArray['description'] = $item->getDescription();
			$items[] = $itemArray;
		}

		$this->assign( 'items', $items);
		$this->assign( 'list', $list);
		$this->_config['template'] = 'lof/slider/'.$theme.'/list_sliders.phtml';	
	}
}
