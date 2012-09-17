<?php
class SlayerBirden_ProductAttribute_Adminhtml_ProductattributeController extends Mage_Adminhtml_Controller_Action
{
    public function saveAction()
    {
        $result = new Varien_Object();
        $result->setError(0);
        $result->setErrorMessage('');
        $result->setOptionId(0);

        $post = $this->getRequest()->getPost();
        if (empty($post)) {
            $result->setError(1);
            $result->setErrorMessage($this->__('The input data is empty'));
            $this->getResponse()->setBody($result->toJson());
            return;
        }
        try {
            /** @var $attribute Mage_Eav_Model_Attribute */
            $attributeId = Mage::getModel('eav/entity_attribute')->getIdByCode(Mage_Catalog_Model_Product::ENTITY, $post['attr_code']);
            $attribute = Mage::getModel('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeId);
            if (!$attribute->getId()) {
                $result->setError(1);
                $result->setErrorMessage($this->__('Invalide attribute code.'));
            } else {
                $optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                    ->setAttributeFilter($attribute->getId())
                    ->setPositionOrder('desc', true)
                    ->load();
                $duplicate = false;
                // check if option is not present already
                foreach ($optionCollection as $option) {
                    if ($option->getValue() == $post['value']) {
                        $duplicate = true;
                        break;
                    }
                }
                if (!$duplicate) {
                    $attribute->addData(array('option' => array('value'=>array('option'=>array($post['value'])))));
                    $attribute->save();
                    $optionId = $attribute->getSource()->getOptionId($post['value']);
                    if ($optionId) {
                        $result->setOptionId($optionId);
                    }
                }
            }
        } catch (Mage_Core_Exception $e) {
            $result->setError(1);
            $result->setErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $result->setError(1);
            $result->setErrorMessage($this->__('There was an exception during saving an option. It was logged.'));
            Mage::logException($e);
        }
        $this->getResponse()->setBody($result->toJson());
        return;
    }
}