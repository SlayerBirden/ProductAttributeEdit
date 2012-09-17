<?php
class SlayerBirden_ProductAttribute_Block_Adminhtml_Catalog_Product_Edit_Tab_Attributes extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Attributes
{
    protected function _getAdditionalElementHtml($element)
    {
        $html = '';
        if ($element->getEntityAttribute()->getIsUserDefined() &&
            ($element->getType() == 'select' || $element->getType() == 'multiselect')) {
            $html = '<button type="button" class="scalable add" onclick="om.addOneOption(\''.$element->getEntityAttribute()->getAttributeCode().'\', this);return false;"><span><span>Add an option</span></span></button>';
        }
        return $html;
    }
}
