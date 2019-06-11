<?php

namespace Redstage\Banner\Helper;

use Magento\Framework\App\Helper\Context;
use Redstage\Banner\Model\BannerFactory;
use Redstage\Banner\Logger\Logger;

class Data extends \Magento\Framework\App\Helper\AbstractHelper{

    protected $_bannerFactory;

    protected $_logger;

    public function __construct(
        Context $context,
        BannerFactory $bannerFactory,
        Logger $logger
    ) {
        parent::__construct($context);
        $this->_bannerFactory = $bannerFactory;
        $this->_logger = $logger;
    }

    /**
     * @param null $id
     *
     * @return Collection
     */
    public function getCategoryBannerCollection($categoryId = null)
    {
        $collection = $this->_bannerFactory->create()->getCollection()->addFieldToFilter('status', 1);

        $collection 
            ->setPageSize(10) // only get 10 products 
            ->setCurPage(1)  // first page (means limit 0,10)
            ->load(); 

        return $collection->getFirstItem();
    }

    /**
     * @param null $id
     *
     * @return Collection
     */
    public function getProductBannerCollection($productId = null)
    {
        $collection = $this->_bannerFactory->create()->getCollection()->addFieldToFilter('status', 1);

        $collection 
            ->setPageSize(10) // only get 10 products 
            ->setCurPage(1)  // first page (means limit 0,10)
            ->load(); 

        return $collection->getFirstItem();
    }

}