<?php
class SlayerBirden_ProductAttribute_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes
{
    protected function _getAdditionalElementHtml($element)
    {
        if ($element->getType() == 'select' || $element->getType() == 'multiselect') {
            // logic here
        }
    }
}
