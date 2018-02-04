<?php
namespace Commer\CustomOrderNumber\Model;

use Magento\Sales\Model\EntityInterface;

class ShipmentResource extends \Magento\Sales\Model\ResourceModel\Order\Shipment {
    
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
            $id = $this->sequenceManager->getSequence(
                    $object->getEntityType(),
                    $object->getStoreId()
                )->getNextValue();
            $object->setIncrementId($id);
        }
        parent::_beforeSave($object);
        return $this;
    }


}