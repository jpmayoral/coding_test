<?php

namespace Redstage\Banner\Model\Banner;

use Redstage\Banner\Model\ResourceModel\Banner\CollectionFactory;

use Redstage\Banner\Logger\Logger;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_logger;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        Logger $logger,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_logger = $logger;
    }

    public function getData()
    {
        $this->_logger->info(__METHOD__);

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $banner) {
            $this->loadedData[$banner->getId()] = $banner->getData();
        }

        $this->_logger->info('loadedData: '.print_r($this->loadedData,true));

        return $this->loadedData;

    }
}
