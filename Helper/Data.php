<?php

namespace Commer\CustomOrderNumber\Helper;


class Data extends \Augustash\CustomOrderNumber\Helper\Data
{
    protected $storeViewId = 0;
    
    public function getStoreViewId(){
        return $this->storeViewId ? $this->storeViewId : 0;
    }
    
    public function setStoreViewId($v) {
        $this->storeViewId = $v;
    }

    public function getConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreViewId()
        );
    }
}
