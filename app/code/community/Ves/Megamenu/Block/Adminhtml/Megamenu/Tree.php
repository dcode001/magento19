<?php

/******************************************************
 * @package Ves Megamenu module for Magento 1.4.x.x and Magento 1.7.x.x
 * @version 1.0.0.1
 * @author http://landofcoder.com
 * @copyright	Copyright (C) December 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/
?>
<?php

class Ves_Megamenu_Block_Adminhtml_Megamenu_Tree extends Mage_Adminhtml_Block_Template {

    public function __construct() {
        parent::__construct();
        $this->setTemplate('ves_megamenu/megamenu/tree.phtml');
        $this->setUseAjax(true);
    }

    protected function _prepareLayout() {
        $this->setChild('import_category_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Import Categories'),
                            'onclick' => "importCategories('" . $this->getUrl('*/*/importCategories') . "')",
                            'id' => 'add_subvesmegamenu_button'
                        ))
        );

        $this->setChild('add_sub_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Add Sub MegaMneu'),
                            'onclick' => "addNew('" . $this->getUrl('*/*/edit') . "', false)",
                            'class' => 'add',
                            'id' => 'add_subvesmegamenu_button'
                        ))
        );

        $this->setChild('add_root_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('catalog')->__('Add Root Megamenu'),
                            'onclick' => "addNew('" . $this->getUrl('*/*/edit') . "', true)",
                            'class' => 'add',
                            'id' => 'add_root_vesmegamenu_button'
                        ))
        );

        $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher')
                        ->setSwitchUrl($this->getUrl('*/*/*'))
                        ->setTemplate('ves_megamenu/store/switcher.phtml')
        );
        return parent::_prepareLayout();
    }

    public function getStore() {
        if ($storeId = (int) $this->getRequest()->getParam('storeId'))
            return $storeId;
        elseif (Mage::getSingleton('admin/session')->getLastViewedStore())
            return Mage::getSingleton('admin/session')->getLastViewedStore();
        return $this->_getDefaultStoreId();
    }

    public function getRoot() {
        $root = Mage::registry('root');
        if (is_null($root)) {
            $storeId = (int) $this->getRequest()->getParam('store');
            $rootIds = null;
            if ($storeId) {
                $rootIds = Mage::getModel('ves_megamenu/megamenu')->getRootId($storeId);
            } else {
                $rootIds = Mage::getModel('ves_megamenu/megamenu')->getRootId(0);
            }
            $root = array();
            foreach ($rootIds as $rootId) {
                $root[] = Mage::getModel('ves_megamenu/megamenu')->load($rootId);
            }

            Mage::register('root', $root);
        }
        return $root;
    }

    protected function _getDefaultStoreId() {
        return Ves_Megamenu_Model_Abtract::DEFAULT_STORE_ID;
    }

    public function getMegamenuCollection() {
        $storeId = $this->getRequest()->getParam('store', $this->_getDefaultStoreId());
        $collection = $this->getData('megamenu_collection');
        if (is_null($collection)) {
            $collection = Mage::getModel('ves_megamenu/megamenu')->getCollection();

            $collection->setStoreFilter($storeId);

            $this->setData('megamenu_collection', $collection);
        }
        return $collection;
    }

    public function getImportCategoriesButtonHtml() {
        return $this->getChildHtml('import_category_button');
    }

    public function getAddRootButtonHtml() {
        return $this->getChildHtml('add_root_button');
    }

    public function getAddSubButtonHtml() {
        return $this->getChildHtml('add_sub_button');
    }

    public function getExpandButtonHtml() {
        return $this->getChildHtml('expand_button');
    }

    public function getCollapseButtonHtml() {
        return $this->getChildHtml('collapse_button');
    }

    public function getStoreSwitcherHtml() {
        return $this->getChildHtml('store_switcher');
    }

    public function getTreeHtml() {
        $storeId = $this->getStore();
        $storeId = empty($storeId) ? 0 : $storeId;
        return '<ul id="single-tree" class="simpleTree">'
                . Mage::getModel('ves_megamenu/megamenu')->renderTree(null, 0, $this->getRequest()->getParam('id'), $this->getStore())
                . '</ul>'
                . '<script type="text/javascript">'
                . '//<![CDATA[' . "\n"
                . 'var simpleTreeCollection = $jMega("#single-tree").simpleTree({'
                . 'animate: true,'
                . 'docToFolderConvert: true,'
                . 'spaceImage: "' . $this->getSkinUrl('ves_megamenu/images/spacer.gif') . '",'
                . 'minusImage: "' . $this->getSkinUrl('ves_megamenu/images/minus.gif') . '",'
                . 'plusImage: "' . $this->getSkinUrl('ves_megamenu/images/plus.gif') . '",'
                . 'afterClick: function(node) {'
                . 'var id = node.attr("id");'
                . 'var storeId = ' . $this->getStore() . ';'
                . 'afterClick(id, storeId);'
                . '},'
                . 'afterMove: function(destination, source, pos) {'
                . 'var parentId = destination.attr("id");'
                . 'var moveId = source.attr("id");'
                . 'afterMove(parentId, moveId);'
                . '},'
                . '});' . "\n"
                . '//]]>'
                . '</script>';
    }

    /**
     * Retrieve currently edited product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getMegamenu() {
        return Mage::registry('current_megamenu');
    }

}