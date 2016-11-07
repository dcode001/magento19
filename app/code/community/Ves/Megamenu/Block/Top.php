<?php
/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
if (!class_exists("Ves_Megamenu_Block_List")) {
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "List.php";
}

class Ves_Megamenu_Block_Top extends Ves_Megamenu_Block_List {
	
	var $menus = null;
	var $modid = '';
    function _toHtml() {
		
		$theme = ($this->getConfig('topTheme') != "") ? $this->getConfig('topTheme') : "black";
		$menuHtml = $this->getHtml($this->_config);
        $items = array();
		$responmenu = "";
		
		$_model = Mage::getModel('ves_megamenu/megamenu');
		$parentId = $this->getConfig("topCategory")?$this->getConfig("topCategory"):1;

		$menus = $_model->getMegaMenus( null, true, $position_type );
		$children = array();
		foreach ( $menus as $v ){	
			$pt 	= $v["parent_id"];
			$list 	= @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );
			$children[$pt] = $list;
			 
		}
		// echo $this->getRequest()->getRouteName();die;
		$html = "";
		$responsive = '';
		$this->menus = $children;

		if( $this->hasSubMenu($parentId) ){
			$html .= $this->renderMenuItem( $html, $this->getMenuList( $parentId ), 0 );
			if( $this->getConfig("responsive") ){
				$responsive .= '<ul class="level0" id="ves-responmenu">';
				$responsive .= $this->renderMenuTree( $this->getMenuList($parentId) );
				$responsive .= "</ul>"; 
			// 	echo '<pre>'.print_r( $responsive, 1 ); die;
			}
		}		
		$this->assign( "responsive", $responsive );
        $this->assign('menuHtml', $html);
        $theme = ($this->getConfig('topTheme') != "") ? $this->getConfig('topTheme') : "black";
		$this->_config['template'] = 'ves/megamenu/default.phtml';
		$content = $this->getLayout()->createBlock('Ves_Megamenu_Block_Source_Megamenumedia',"megamenu_media")->toHtml();
        // render html
		$this->assign('content', $content);
        $this->assign('config', $this->_config);
        $this->setTemplate($this->_config['template']);
        return parent::_toHtml();
    }
	
	public function getMenuClassAcitve( $type ){

		switch(  $this->getRequest()->getRouteName()  ){
			case 'catalog':
				if( $this->getRequest()->getParam('id') == $menu['article'] ){
					return ' active';
				}
				break;
			case 'cms_page':
				if( $this->getRequest()->getParam('page_id') == $menu['article'] ){
					return ' active';
				}
				break;
			
		}
			

		return '';
	}
	public function renderMenuTree( $menus, $level=0 ){
		$html ="";
		foreach( $menus as $menu ){
			$class="";$span ="";
			$class .= " ".$menu['menu_class'];
			if( $this->hasSubMenu($menu["megamenu_id"]) ){
				$class .= " haschild ";
				$span = '<span class="btn-action"></span>';
			}
				$class .= $this->getMenuClassAcitve($menu);
				$html .= '<li class="respon-menu level'.$level.$class.'">';
				$link =  trim($menu['type']) == "static_block"  ?'#':$this->getMenuLink( $menu );
				$html .= '<a href="'.$link.'" title="'.$menu['title'].'" ><span>'.$menu['title'].'</span>'."</a>";
				
				$html .= $span;	
				
					if( $this->hasSubMenu($menu["megamenu_id"]) ){
						$html .= '<ul class="level'.($level+1).'">';
							$html .= $this->renderMenuTree( $this->getMenuList($menu["megamenu_id"]), $level+1 );
						$html .= '</ul>';
					
					}
			$html .="</li>";
		}
		return $html;
	}
	
    public function getListByParameters($params, $pparams) {
        return $this->getHtml($params);
    }
	
 
	/**
	 * render list of menu item in level 0
	 */
	public function renderMenuItem( $html, $menus, $level=0 ){	
		foreach( $menus as $j => $menu ){ 
			$iclass = $menu['menu_class'];
			if( $this->hasSubMenu($menu["megamenu_id"]) ){
				$iclass .= " haschild";
			}
			if( $j==0){	$iclass .=" first";}
			elseif( ($j+1)==count($menus) ){	$iclass .=" last";}
			$iclass .= $menu['is_group']==1?" megagroup":"";
			$iclass .= $this->getMenuClassAcitve($menu);
			$html .='<li id="menu-'.$menu['megamenu_id'].'" class="level'.$level. " " . $iclass.' mega">';
			//	echo '<pre>'.print_r( $menu, 1 ); die;
				$html .= $this->renderMenuContent( $level, $menu );
			$html .='</li>';
		}
		return $html;
	}
	
	/**
	 * render list of submenu of next level.
	 */
	public function renderSubMenu( $html="", $menus, $level, $parent ){
		
		$dwidth = (int)$parent['submenu_width']>0?(int)$parent['submenu_width']:200;
		$colswidth = (int)$parent['colum_width']>0?(int)$parent['colum_width']:200;
		
		$cols = (int)$parent['colums'] > 1?(int)$parent['colums']:1;
		if( $cols > count($menus) ){ $cols = count($menus);	}
		if( (int)$parent['submenu_width'] <= 0 ){$dwidth = $colswidth*$cols; }

		
		$gClass = $parent['is_group']==1?" menugroup":" menunongroup";
		$html = '<div style="width:'.$dwidth.'px" id="menu-'.$parent['megamenu_id'].'_menusub_sub'.$level.'" class="level'.$level.$gClass.'"><div class="submenu-wrapper">';	

		// one columns
		if( $cols <= 1 ){	
			$html .= '<ul class="megamenu">';
			foreach( $menus as $j=> $menu ){ 
				$menuClass = "";
				$iclass = $menu['menu_class'];
				if( $this->hasSubMenu($menu["megamenu_id"]) ){$iclass .= " haschild";}
				if( $j==0){	$iclass .=" first";}
				elseif( ($j+1)==count($menus) ){$iclass .=" last";}
				$iclass .= $menu['is_group']==1?" megagroup":"";
				$html .= '<li id="menu-'.$menu['megamenu_id'].'" class="level'.$level.$iclass.' mega">';
				 	$html .= $this->renderMenuContent( $level, $menu );
				$html .='</li>';
			}
			$html .= '</ul>';
		}else{ // number of menu items greater then number of columns.
			// split menu items following number of columns
			$spcols = array_chunk( $menus, ceil(count($menus)/$cols) );	
			foreach( $spcols as $k => $colmenus){
				$ocolWidth = $this->getColWidth( $colmenus );
				$tmp = isset($ocolWidth['col'.($k+1)])?$ocolWidth['col'.($k+1)]:$colswidth;
				$html .= '<div class="vescolumn col'.($k+1).'" style="width:'.$tmp.'px">';
					$html .='<ul class="megamenu">';
					foreach( $colmenus as $j=> $_menu ){
						$iclass = $_menu['menu_class'];
						if( $this->hasSubMenu($menu["megamenu_id"]) ){$iclass .= " haschild";}
						if( $j==0){	$iclass.=" first";}
						elseif( ($j+1)==count($colmenus) ){	$iclass .=" last";}
						$iclass .= $_menu['is_group']==1?" megagroup":"";
						$html .='<li class="mega level'.($level+1).$iclass.'">';
							$html .= $this->renderMenuContent( $level, $_menu );
						$html .='</li>';
					}
					$html .='</ul>';
				$html .= '</div>';
			}
		}
		$html .= '</div></div>';
		return $html;
	}
	
	/**
	 * render menu content and its submenu
	 * 
	 * @param $level
	 * @param $menu
	 */
	protected function renderMenuContent( $level, $menu ){
		$html ="";
		
	// 	echo '<pre>'.print_r( $menu, 1 ); die;
		if( trim($menu['type']) == "static_block" ){
			$html .= $this->renderBlockStatic( $menu['article'] );
		}else {
			$link = $this->getMenuLink( $menu ); //echo '<pre>'.print_r( $menu,1); die;
			
			if( !$menu['show_title'] ){
					$menu['title']="";
					$menu['description']="";		
			} 
			
			$span = '<span class="menu-title">'.$menu['title'].'</span><span class="menu-desc">'.$menu['description'].'</span>';
			if( $menu['image'] ){
				$iurl = Mage::getBaseUrl('media').$menu['image'];
				$span = '<span class="has-image" style="background-image:url('.$iurl.')">'.$span.'</span>';
			}	
			$text = '<a target="'.$menu['target'].'" class="mega"  href="'.$link.'">'.$span.'</a>';
			if( $menu['is_group']==1 ){	
				$html .= '<div class="group-title">'.$text.'</div>';
			} else {
				$html .= $text;
			}
		}
	
		$dwidth = (int)$menu['submenu_width']>0?(int)$menu['submenu_width']:200;
		
		
		switch( $menu['type_submenu'] ){
			case 1: // submenus are categories link
				$html .= Mage::helper('ves_megamenu/Subtype')->renderMenuByCategories( $menu, $dwidth, $level );			
				break;
			case 2: // submenus are products link
			
				break;
			case 3: // submenus are statics blocks content
				$html .= $this->renderMenuByModules( $menu, $dwidth, $level );
				break;
			case 4: // submenus are cms pages link
				$html .= Mage::helper('ves_megamenu/Subtype')->renderMenuByCMSs( $menu, $dwidth, $level );
				break;			
			case 5: // submenus are text-html content
				$html .= Mage::helper('ves_megamenu/Subtype')->renderMenuByText( $menu, $dwidth, $level );				 
				break;	
			case 0:  // if submenu type is list of menu items
			default:
				
				if( $this->hasSubMenu($menu["megamenu_id"]) ){ 	
					$html .= $this->renderSubMenu( "", $this->getMenuList($menu["megamenu_id"]), $level+1,  $menu );
				}
				break;
		}
	 
		return $html;			
	}
	public function getColWidth( $menu ){
		return Mage::helper('ves_megamenu/Subtype')->getColWidth( $menu );
	}
	public function renderMenuByModules( $menu, $dwidth, $level, $owidth=array() ){
		$ids = explode(',', $menu['submenu_content']);
		$colswidth = (int)$menu['colum_width']>0?(int)$menu['colum_width']:200;
		$ocolWidth = $this->getColWidth( $menu );
		if( !empty($ids) ){
			$modules = array();
			foreach( $ids as $id ){
			  $modules[] = $this->getLayout()->createBlock('cms/block')->setBlockId( $id )->toHtml();
			}
			$cols = (int)$menu['colums'] > 0 ? (int)$menu['colums'] : 1;
			$spcols = array_chunk( $modules, ceil(count($modules)/$cols) );	
			$context = "";	
			
			
			foreach( $spcols as $k => $modules){
				$tmp = isset($ocolWidth['col'.($k+1)])?$ocolWidth['col'.($k+1)]:$colswidth;
				$context .= '<div class="vescolumn col'.($k+1).'" style="width:'.$tmp.'px">';
					$context .='<ul class="megamenu">';
					foreach( $modules as $j=>$module ){ 
						$iclass="";
						if( $this->hasSubMenu($menu["megamenu_id"]) ){$iclass .= " haschild";}
						if( $j==0){	$iclass .=" first";}
						elseif( ($j+1)==count($modules) ){	$iclass .=" last";}
						$context .='<li class="mega level'.($level+1). $iclass.'">';
							$context .= $module;
						$context .='</li>';
					}
					$context .='</ul>';
				$context .= '</div>';
			}
			
			$gClass = $menu['is_group']==1?" menugroup":" menunongroup";
			$html = '<div style="width:'.$dwidth.'px" id="menu-'.$menu['megamenu_id'].'_menusub_sub'.($level+1).'" class="  level'.($level+1).$gClass.'"><div class="submenu-wrapper">';
			$html .= $context;
			$html .= '</div></div>';
			return $html;
		}
		return ;
	}
	public function getMenuLink( $menu ){
		switch( $menu['type'] ){
			case 'category':
				return 	Mage::getModel("catalog/category")->load( $menu['article'] )->getUrl();
				break;
			case 'product':
				return Mage::getModel('catalog/product')->load($productid)->getProductUrl(); 
				break;
			case 'cms_page':
				$page = Mage::getModel('cms/page')->load( $menu['article'] );
				if( $page->getIdentifier() == Mage::getStoreConfig('web/default/cms_home_page') ){
					return Mage::getBaseUrl();
				} else {
					return Mage::helper('cms/page')->getPageUrl( $menu['article'] );
				}
				break;
			default:
				return trim($menu['article']);
				break;
		}	
		return ;
	}
	
	/**
	 * render static block by id
	 */
	public function renderBlockStatic( $id ){
		return $this->getLayout()->createBlock('cms/block')->setBlockId( $id )->toHtml();
	}
	
	/**
	 * get childrent menu by parent id
	 */
	public function getMenuList( $id ){
		return $this->menus[$id];
	}
	
	/**
	 * check menu having sub menu or not
	 */
	public function hasSubMenu( $id ){
		return isset($this->menus[$id]); 
	}
	
	/**
	 * get url icon
	 */
	public function getMenuIcon( $image ){
		if ( file_exists( Mage::getBaseDir('media') . DS . $image ) ){
			return Mage::getBaseDir('media') . DS . $image;
		}
		return '';
	}
	 
}
