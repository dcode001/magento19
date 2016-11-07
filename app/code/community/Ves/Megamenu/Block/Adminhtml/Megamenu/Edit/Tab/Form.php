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

class Ves_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();

        $this->setForm($form);

        
        
        
        
        $fieldset = $form->addFieldset('megamenu_form', array('legend' => Mage::helper('ves_megamenu')->__('Megamenu information')));



        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('ves_megamenu')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'ves_megamenu[title]',
        ));



        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('ves_megamenu')->__('Image'),
            'required' => false,
            'name' => 'image',
        ));



        if (!Mage::app()->isSingleStoreMode()) {

            $fieldset->addField('stores', 'multiselect', array(
                'label' => Mage::helper('ves_megamenu')->__('Visible In'),
                'required' => true,
                'name' => 'ves_megamenu[stores][]',
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
                'value' => 'stores'
            ));
        } else {

            $fieldset->addField('stores', 'hidden', array(
                'name' => 'ves_megamenu[stores][]',
                'value' => Mage::app()->getStore(true)->getId()
            ));
        }



        $fieldset->addField('parent_id', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Parent Item'),
            'name' => 'ves_megamenu[parent_id]',
            'values' => $this->itemToOptionArray(),
        ));



        $fieldset->addField('article', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Select Article'),
            'name' => 'ves_megamenu[article]',
            'values' => $this->acticleToOptionArray(),
        ));



        $fieldset->addField('is_group', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Is Group'),
            'name' => 'ves_megamenu[is_group]',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('ves_megamenu')->__('True'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('ves_megamenu')->__('False'),
                ),
            ),
        ));



        $fieldset->addField('width', 'text', array(
            'label' => Mage::helper('ves_megamenu')->__('Width'),
            'required' => false,
            'name' => 'ves_megamenu[width]',
        ));



        $fieldset->addField('subitem_width', 'textarea', array(
            'label' => Mage::helper('ves_megamenu')->__('Submenu Item Width'),
            'required' => false,
            'name' => 'ves_megamenu[subitem_width]',
        ));



        $fieldset->addField('is_content', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Is Content'),
            'name' => 'ves_megamenu[is_content]',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('ves_megamenu')->__('True'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('ves_megamenu')->__('False'),
                ),
            ),
        ));



        $fieldset->addField('show_title', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Show Title 1'),
            'name' => 'ves_megamenu[show_title]',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('ves_megamenu')->__('True'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('ves_megamenu')->__('False'),
                ),
            ),
        ));



        $fieldset->addField('col', 'text', array(
            'label' => Mage::helper('ves_megamenu')->__('Col Position'),
            'required' => false,
            'name' => 'ves_megamenu[col]',
        ));



        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('ves_megamenu')->__('Status'),
            'name' => 'ves_megamenu[status]',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('ves_megamenu')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('ves_megamenu')->__('Disabled'),
                ),
            ),
        ));
		$fieldset->addField('content_text', 'editor', array(
			'name'      => 'content_text',
			'label'     => Mage::helper('cms')->__('Content Text'),
			'title'     => Mage::helper('cms')->__('Content Text'),
			'style'     => 'height:36em;',
			'wysiwyg'   => true,
			'theme' => 'advanced',
			'required'  => false,
			));



        if (Mage::getSingleton('adminhtml/session')->getMegamenuData()) {

            $form->setValues(Mage::getSingleton('adminhtml/session')->getMegamenuData());

            Mage::getSingleton('adminhtml/session')->setMegamenuData(null);
        } elseif (Mage::registry('megamenu_data')) {

            $form->setValues(Mage::registry('megamenu_data')->getData());
        }

        return parent::_prepareForm();
    }

    public function itemToOptionArray() {

        $optionArray = array();

        $collection = Mage::getModel('ves_megamenu/megamenu')->getCollection();

        if ($this->getRequest()->getParam('id')) {

            $collection->addFieldToFilter('ves_megamenu_id', array('neq' => $this->getRequest()->getParam('id')));
        }

        $optionArray[] = array('value' => '', 'label' => '');

        foreach ($collection as $item) {

            $level = '...';

            if ($item->getLevel()) {

                for ($i = 0; $i < $item->getLevel(); $i++) {

                    $level .= '...';
                }
            }

            $optionArray[] = array('value' => $item->getId(), 'label' => $level . $item->getTitle());
        }

        return $optionArray;
    }

    public function acticleToOptionArray() {

        $option = null;

        if ($this->getRequest()->getParam('type')) {

            $option = $this->getRequest()->getParam('type');
        } else {

            $megamenu = null;

            if (Mage::getSingleton('adminhtml/session')->getMegamenuData()) {

                $megamenu = Mage::getSingleton('adminhtml/session')->getMegamenuData();
            } elseif (Mage::registry('megamenu_data')) {

                $megamenu = Mage::registry('megamenu_data')->getData();
            }



            if ($megamenu) {

                $option = $this->getLayout()->getBlock('ves_megamenu.type')->nodeToOptionArray($megamenu['type']);
            }
        }

        return $option;
    }

}