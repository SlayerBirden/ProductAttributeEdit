<?php
class SlayerBirden_ProductAttribute_Model_Observer
{
    protected $_attributeTabBlock = 'sb_productattribute/adminhtml_catalog_product_edit_tab_attributes';

    public function assignTab($observer)
    {
        Mage::helper('adminhtml/catalog')->setAttributeTabBlock($this->_attributeTabBlock);
        return $this;
    }
}