<?php
namespace Commer\CustomOrderNumber\Model;

use Magento\Sales\Model\EntityInterface;

class InvoiceResource extends \Magento\Sales\Model\ResourceModel\Order\Invoice {
    
    /**
     * Perform actions before object save
     * Perform actions before object save, calculate next sequence value for increment Id
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /** @var \Magento\Sales\Model\AbstractModel $object */
        if ($object instanceof EntityInterface && $object->getIncrementId() == null) {
            $object->setIncrementId(
                $this->sequenceManager->getSequence(
                    $object->getEntityType(),
                    $object->getStoreId()
                )->getNextValue()
            );
        }
        parent::_beforeSave($object);
        return $this;
    }


}