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
 
class Lof_Slider_Block_Image extends Lof_Slider_Block_List 
{
	function _toHtml() {		 
		if( !$this->_show || !$this->getConfig('show') ) return;
		$theme = ($this->getConfig('theme')!="") ? $this->getConfig('theme') : "default";
		// check the source used ?
		if( $this->getConfig('source') == 'file' )
		{
			$this->__renderSlideShowImagegroup();
		} 
		else 
		{
			$this->__renderSlideShowImages();
			$this->_config['template'] = 'lof/slider/'.$theme.'/list.phtml';
		}
		// render html
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
			$mainImage = $this->buildThumbnail( $imageArray,
												  $this->_config['mainWidth'],
												  $this->_config['mainHeight'] );
			$thumbnail = $this->buildThumbnail( $imageArray,
												  $this->_config['thumbWidth'],
												  $this->_config['thumbHeight'] );
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
	
	/**
	 * render block content for the slideshow using the list of images in a folder.
	 */
	private function __renderSlideShowImages(){
		// init values.
		$descriptionArray = $mainsThumbs = $imageArray     = array();
		$thumbArray = array();
		$captionsArray = array();
		$urls = array();
		
		$listImgs = $this->getFileInDir();
		
		
		if($this->_config['showdesc'])
		{			
			$descriptionArray = $this->parseDescNew ( $this->getConfig('description') );
			if ( !count($descriptionArray) )
			{
				$descriptionArray = $this->parseDescOld ( $this->getConfig('description') );	
			}
		}
			
			
		if (count($listImgs) > 0) 
		{			
			foreach($listImgs as $k=>$img) 
			{
				$imageArray[] = $this->_config['folder'].'/'.$img;
				if($this->_config['showdesc'])
				{
					$captionsArray[] = (isset($descriptionArray) 
											  && isset($descriptionArray[$img])
											  && isset($descriptionArray[$img]['caption']))
									? str_replace("'", "\'", $descriptionArray[$img]['caption']) :'';
				}
				$url = (isset($descriptionArray[$img]) 
												&& isset($descriptionArray[$img]['url']))
					? $descriptionArray[$img]['url'] :'';
					
				$urls[] = $url;
				
			}
			// generate mainImages and thumbnail Images.
			$mainsThumbs = $this->buildThumbnail( $imageArray, $this->_config['mainWidth'], $this->_config['mainHeight'] );
			$thumbArray = $this->buildThumbnail ( $imageArray, $this->getConfig('thumbWidth'), $this->getConfig('thumbHeight') );		
		}

		$this->assign('thumbArray', $thumbArray);		
		$this->assign('mainsThumbs', $mainsThumbs);		
		$this->assign('listImgs', $imageArray);
		$this->assign('descriptionArray', $descriptionArray);		
		$this->assign('captionsArray', $captionsArray);		
		$this->assign('urls', $urls);		
	}
	
    function parseDescNew($description) {
		$regex = '#\[desc ([^\]]*)\]([^\[]*)\[/desc\]#m';
		
		preg_match_all ($regex, $description, $matches, PREG_SET_ORDER);
		
		$descriptionArray = array();
		foreach ($matches as $match) {
		$params = $this->parseParams($match[1]);
		if (is_array($params)) {
		$img = isset($params['img'])?trim($params['img']):'';
		if (!$img) continue;
		$url = isset($params['url'])?trim($params['url']):'';
		$descriptionArray[$img] = array('url'=>$url,'caption'=>str_replace("\n","<br />",trim($match[2])));
		}
		}
		return $descriptionArray;
    }
	function parseDescOld ($description) 
	{
      $description = str_replace("<br />", "\n", $description);
      $description = explode("\n",$description);
      $descriptionArray = array();
      foreach($description as $desc)
	  {
        if ($desc) 
		{
          $list = explode(":", $desc, 2);
          $list[1] = (count($list) > 1) ? explode("&", $list[1]) : array();
          $temp = array();
          for ($i = 0; $i < count($list[1]); ++$i) {
            $l = explode("=", $list[1][$i]);
            if(isset($l[1]))
            	$temp[trim($l[0])] = trim($l[1]);
          }
          $descriptionArray[$list[0]] = $temp;
        }
      }
      return $descriptionArray;
    }
	/**
	 * Get List of Images File In Configured Directory
	 */
	public function getFileInDir()
	{
		
		if(!$this->_config['folder']) return ;
		$imagePath = Mage::getBaseDir().DIRECTORY_SEPARATOR.$this->_config['folder'];
		if(!is_dir($imagePath)) return array();
		$imgFiles   = $this->files($imagePath,".bmp|.gif|.jpg|.png|.jpeg");
		
		return $imgFiles;
	}
	
	/**
	 * Find list of files inside folder 
	 */
	public function files($path, $filter = '.', $recurse = false, $fullpath = false, $exclude = array('.svn', 'CVS')){
		// Initialize variables
		$arr = array ();
		// Is the path a folder?
		if (!is_dir($path)) {
			return array();
		}
		// read the source directory
		$handle = opendir($path);
		while (($file = readdir($handle)) !== false)
		{
			$dir = $path.DIRECTORY_SEPARATOR.$file;
			$isDir = is_dir($dir);
			if (($file != '.') && ($file != '..') && (!in_array($file, $exclude))) {
				if ($isDir) {
					if ($recurse) {
						if (is_integer($recurse)) {
							$recurse--;
						}
						$arr2 = files($dir, $filter, $recurse, $fullpath);
						$arr = array_merge($arr, $arr2);
					}
				} else {
					if (preg_match("/$filter/", $file)) {
						if ($fullpath) {
							$arr[] = $path.'/'.$file;
						} else {
							$arr[] = $file;
						}
					}
				}
			}
		}
		closedir($handle);
		asort($arr);
		return $arr;
	}
}
