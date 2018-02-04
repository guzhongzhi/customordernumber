<?php
namespace Commer\CustomOrderNumber\Model;

use Magento\Quote\Model\ResourceModel\Quote;


class QuoteResource extends Quote {
    
    
    
    /**
     * Get reserved order id
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @return string
     */
    public function getReservedOrderId($quote)
    {
        $id = $this->sequenceManager->getSequence(
            \Magento\Sales\Model\Order::ENTITY,
            $quote->getStore()->getId()
            //$quote->getStore()->getGroup()->getDefaultStoreId()
        )
        ->getNextValue();
        
        return $id;
    }


}