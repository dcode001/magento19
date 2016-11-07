<?php

/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

class Ves_Megamenu_Adminhtml_MegamenuController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->_title($this->__('Manage Megamenu Items'))
                ->_title($this->__('Megamenu'));

        $this->loadLayout()
                ->_setActiveMenu('ves/megamenu')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {

        $this->_forward('edit');
    }

    public function index2Action() {
        $this->_forward('edit', null, null, array("position_type" => "left"));
    }

    public function editAction($position_type = "top") {
		
        $position_type = $this->getRequest()->getParam('position_type');
        Mage::getSingleton('admin/session')
                ->setMegaPositionType($position_type);

        $id = $this->getRequest()->getParam('id');
        $megamenu = Mage::getModel('ves_megamenu/megamenu')->load($id);
        Mage::register('current_megamenu', $megamenu);
        if ($this->getRequest()->getQuery('isAjax')) {
            $result = array();
            $storeId = $this->getRequest()->getParam('storeId');
            $storeId = !empty($storeId) ? $storeId : 0;
            Mage::getSingleton('admin/session')
                    ->setLastViewedStore($storeId);
            Mage::getSingleton('admin/session')
                    ->setLastEditedMegamenu($megamenu->getId());
            $this->loadLayout();
            $result['messages'] = $this->getLayout()->getMessagesBlock()->getGroupedHtml();
            $result['content'] = $this->getLayout()->getBlock('megamenu.edit')->getFormHtml();
            if (!$id)
                $result['tree'] = $this->getLayout()->createBlock('ves_megamenu/adminhtml_megamenu_tree')->getTreeHtml();
            $this->getResponse()->setBody(Zend_Json::encode($result));
            return;
        }
        $this->_initAction();
        $this->renderLayout();
    }

    private function _importCategory($category) {
        $category = $category->load($category->getId());
        $parentCategoryId = $category->getParentId();
        $parentMegamenu = Mage::getModel('ves_megamenu/megamenu')->loadByCategoryId($parentCategoryId);
		$p = $parentMegamenu->getId()>0?$parentMegamenu->getId():1;
        $megamenu = Mage::getModel('ves_megamenu/megamenu')
                ->setTitle($category->getName())
                ->setLevel($category->getLevel() - 1)
                ->setIsContent(2)
                ->setShowTitle(1)
                ->setStatus(1)
				->setPositionType("top")
				->setTypeSubmenu(0)
                ->setType('category')
                ->setArticle($category->getId())
                ->setParentId( $p );
        try {
            $megamenu->save();
        } catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError('Could not import categories');
            throw Exception($e);
        }
    }

    public function importCategoriesAction() {
        $root = Mage::getModel('ves_megamenu/megamenu')
                ->getCollection()
                ->addFieldToFilter('parent_id', 0)
                ->setStoreFilter($this->getRequest()->getParam('store_id'));
        if (count($root)) {
            $existsIds = array();
            $existsCategory = Mage::getModel('ves_megamenu/megamenu')
                    ->getCollection()
                    ->addFieldToFilter('type', 'category');
            foreach ($existsCategory as $category) {
                $existsIds[] = $category->getArticle();
            }

            $collection = Mage::getModel('catalog/category')
                    ->getCollection()
                    ->setOrder('level', 'ASC')
                    ->addFieldToFilter('level', array('gt' => 0));
            try {
                foreach ($collection as $category) {
                    if (!in_array($category->getId(), $existsIds))
                        $this->_importCategory($category);
                }
            } catch (Exception $e) {
				Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError('Could not import categories.');
                return false;
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Could not import Categories');
            return false;
        }
    }

	/**
	 * save data menu
	 */
    public function saveAction() {
        $result = array();
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('ves_megamenu/megamenu');
            $id = 0;
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
            }
            $image = $model->getImage();
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $path = Mage::getBaseDir('media') . DS . 'ves_megamenu';
                    $uploader->save($path, $_FILES['image']['name']);
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                    return;
                }
                $image = 'ves_megamenu' . $uploader->getUploadedFileName();
            }  
	 
            if (isset($data['image']['delete']) && $data['image']['delete'] == 1) {
				$path = Mage::getBaseDir('media') . DS . $image;
				if( $image && file_exists($path) ){
					@unlink($path);
				}
				$image = '';
            }

            $data['megamenu']['image'] = $image;
			$submenu_type = $data["megamenu"]["type_submenu"];
			$submenu_content = isset($data["megamenu"]["submenu_content"])?$data["megamenu"]["submenu_content"]:"";
			switch($submenu_type){
				case "1":
					$submenu_sortby = isset($data["megamenu"]["submenu_sortby"])?$data["megamenu"]["submenu_sortby"]:"";
					$tmp = implode(",", $submenu_content).":".$submenu_sortby;
					$data["megamenu"]["submenu_content"] = $tmp;
				break;
				case "2":
					$submenu_sortby = isset($data["megamenu"]["submenu_sortby2"])?$data["megamenu"]["submenu_sortby2"]:"";
					$submenu_limit = isset($data["megamenu"]["submenu_limit"])?$data["megamenu"]["submenu_limit"]:"0";
					$tmp = implode(",", $submenu_content).":".$submenu_sortby.":".$submenu_limit;
					$data["megamenu"]["submenu_content"] = $tmp;
				break;
				case "3":
				case "4":
					$data["megamenu"]["submenu_content"] = implode(",", $submenu_content);
				break;
			}
            if ($this->getRequest()->getParam('type')) {
                $data['megamenu']['type'] = $this->getRequest()->getParam('type');
            }
			if( !isset($data['megamenu']['parent_id']) || empty($data['megamenu']['parent_id']) ){
				$data['megamenu']['parent_id'] = 1;
			}
            if ($data['megamenu']['parent_id']) {
                $level = Mage::getModel('ves_megamenu/megamenu')->load($data['megamenu']['parent_id'])->getLevel();
                $level += 1;
                $data['megamenu']['level'] = $level;
            } else {
                $root = Mage::getModel('ves_megamenu/megamenu')
                        ->getCollection()
                        ->addFieldToFilter('parent_id', 1)
                        ->setStoreFilter($data['store_id']);
                if (count($root)) {
                    $firstitem = $root->getFirstItem();
                    if ($firstitem->getId() != $id) {
                        Mage::getSingleton('adminhtml/session')->addError('Only one root Menu on Store');
                        $result['redirect'] = $this->getUrl('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                        $this->getResponse()->setBody(
                                '<script type="text/javascript">parent.window.location.href = "' . $result['redirect'] . '";</script>'
                        );
                        return;
                    }
                }
                $data['megamenu']['level'] = 0;
            }
			
            $model->setData($data['megamenu'])
                    ->setStoreId($data['store_id']);
            if ($this->getRequest()->getParam('id'))
                $model->setId($this->getRequest()->getParam('id'));
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
					->addSuccess(Mage::helper('ves_megamenu')
					->__('Megamenu was successfully saved'));
                $result['redirect'] = $this->getUrl('*/*/edit', array('id' => $model->getId()));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $result['redirect'] = $this->getUrl('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        } else {
            Mage::getSingleton('adminhtml/session')
				->addError(Mage::helper('ves_megamenu')
				->__('Could not find anymegamenu to save'));
            $result['redirect'] = $this->getUrl('*/*/edit');
        }
        $this->getResponse()->setBody(
                '<script type="text/javascript">parent.window.location.href = "' . $result['redirect'] . '";</script>'
        );
    }
	
	public function moveAction() {
        $ids = $this->getRequest()->getParam('ids');
        if ($ids) {
            $moveId = $this->getRequest()->getParam('move_id');
            $parentId = $this->getRequest()->getParam('parent_id');
            try {
                $move = Mage::getModel('ves_megamenu/megamenu')->load($moveId);
                if ($move->getParentId() != $parentId) {
                    $move->setParentId($parentId)
                            ->save();
                }
				
				$parnet = Mage::getModel('ves_megamenu/megamenu')->load($parentId);
                $level = $parnet->getLevel()+1;
				$ids = explode(',', $ids);
                $i = 0;
                foreach ($ids as $id) {
                    if ($id) {
                        Mage::getModel('ves_megamenu/megamenu')->load($id)->setPosition($i)->setLevel($level)->save();
                        $i++;
                    }
                }
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return;
            }
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Could not move megamenus.');
            return;
        }
    }
	
	/**
	 * Delete menu item and all of submenu if have
	 */
    public function deleteAction($menuid = null) {
        $menuid = $menuid === null ? $this->getRequest()->getParam('id') : $menuid;
        if ($menuid) {
            try {
                $model = Mage::getModel('ves_megamenu/megamenu');
                if ($model->setId($menuid)->hasChild()) {
                    $childs = $model->setId($menuid)->getChildItem();
                    foreach ($childs as $child) {
                        $this->deleteAction($child->getId());
                    }
                } else {
                    $model->setId($menuid)
                            ->delete();
                }
                $model->setId($menuid)
                        ->delete();
                Mage::getSingleton('adminhtml/session')
					->addSuccess(Mage::helper('adminhtml')
					->__('Item was deleted successfully'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $menuid));
            }
        }
        $this->_redirect('*/*/');
    }

}