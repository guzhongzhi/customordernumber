<?php

namespace Commer\CustomOrderNumber\Controller\Adminhtml\System\Config\Apply;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\SalesSequence\Model\ResourceModel\Meta as ResourceMeta;
use Augustash\CustomOrderNumber\Helper\Data;
use Magento\Framework\Logger\Monolog;

class Creditmemo extends \Augustash\CustomOrderNumber\Controller\Adminhtml\System\Config\Apply\Creditmemo
{

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\SalesSequence\Model\ResourceModel\Meta $meta
     * @param \Augustash\CustomOrderNumber\Helper\Data $helper
     * @param \Magento\Framework\Logger\Monolog $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ResourceMeta $resourceMeta,
        Data $helper,
        Monolog $logger
    )
    {
        parent::__construct($context,$resultJsonFactory,$resourceMeta, $helper, $logger );
        $this->resultJsonFactory = $resultJsonFactory;
        $this->meta = $resourceMeta;
        $this->helper = $helper;
        $storeViewId = $this->getRequest()->getParam("store_view_id",0);
        $helper->setStoreViewId($storeViewId);
        $this->logger = $logger;
    }
}
