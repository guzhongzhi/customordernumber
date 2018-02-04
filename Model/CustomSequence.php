<?php
namespace Commer\CustomOrderNumber\Model;

use Augustash\CustomOrderNumber\Model\CustomSequence AS AugustashCustomSequence;


use Magento\Framework\App\ResourceConnection as AppResource;
use Magento\SalesSequence\Model\Meta;
use Magento\Framework\Logger\Monolog as MonologLogger;

use Augustash\CustomOrderNumber\Helper\Data;

class CustomSequence extends AugustashCustomSequence {
    
    
    protected function _getPatternNumberLength($entityType = 'order')
    {
        switch ($entityType) {
            case 'order':
                $length = $this->helper->getOrderNumberLength();
                break;
            case 'invoice':
                $length = $this->helper->getInvoiceNumberLength();
                break;
            case 'creditmemo':
                $length = $this->helper->getCreditmemoNumberLength();
                break;
            case 'shipment':
                $length = $this->helper->getShipmentNumberLength();
                break;
            default:
                $length = 9; // default Magento value
                break;
        }

        return $length;
    }

    /**
     * Retrieve current value
     *
     * @param callable $result
     * @return string
     */
    public function getCurrentValue()
    {
        
        if (!$this->helper->isEnabled()) {
            return parent::getCurrentValue();
        }
        
        /**
         * Customer sequence functionality enabled so do the following:
         *
         *   + determine the pattern
         *   + format the prefix and suffix values
         *   + calculate the current value
         */
        
        if (!isset($this->lastIncrementId)) {
            
            $this->lastIncrementId = $this->connection->lastInsertId($this->meta->getSequenceTable());
        }
        $profile = $this->meta->getActiveProfile();
        if ($profile) {
            $prefix         = $this->formatPrefix($profile->getPrefix());
            $suffix         = $this->formatSuffix($profile->getSuffix());
        } else {
            $prefix = '';
            $suffix = '';
        }

        $pattern        = $this->getPattern($this->meta->getEntityType());
        $currentValue   = $this->_calculateCurrentValue();
        $this->logger->addDebug('FROM ' . __CLASS__ . '::' . __FUNCTION__);
        $this->logger->addDebug('$pattern: ' . var_export($pattern, true));
        $this->logger->addDebug('$prefix: ' . var_export($prefix, true));
        $this->logger->addDebug('$currentValue: ' . var_export($currentValue, true));
        $this->logger->addDebug('$suffix: ' . var_export($suffix, true));

        $customOrderNumber = sprintf($pattern, $prefix, $currentValue, $suffix);

        $this->logger->addDebug('$customOrderNumber: ' . var_export($customOrderNumber, true));

        return $customOrderNumber;
    }
    
    
    /**
     * Calculate current value depends on start value
     *
     * Copied from Magento\SalesSequence\Model\Sequence::calculateCurrentValue()
     *
     * @return string
     */
    protected function _calculateCurrentValue()
    {
        $profile = $this->meta->getActiveProfile();


        $startValue = ($profile) ? $profile->getStartValue() : 1;
        $step = ($profile) ? $profile->getStep() : 1;
        //return ($this->lastIncrementId - $startValue) * $step + $startValue;
        return ($this->lastIncrementId) * $step + $startValue;
    }
}