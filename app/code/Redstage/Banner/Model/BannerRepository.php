<?php

namespace Redstage\Banner\Model;

use Redstage\Banner\Api\BannerRepositoryInterface;
use Redstage\Banner\Api\Data\BannerInterfaceFactory;
use Redstage\Banner\Model\ResourceModel\Banner as ResourceBanner;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Redstage\Banner\Logger\Logger;

class BannerRepository
    implements BannerRepositoryInterface
{
    /**
     * @var BannerInterfaceFactory
     */
    protected $bannerFactory;

    /**
     * @var ResourceBanner
     */
    protected $resourceBanner;

    /**
     * @var \Redstage\Banner\Model\ResourceModel\Banner\Collection
     */
    protected $bannerCollection;

    protected $loadedBanners = null;

    protected $_logger;

    public function __construct(
        \Redstage\Banner\Api\Data\BannerInterfaceFactory $bannerFactory,
        ResourceBanner $resourceBanner,
        \Redstage\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollection,
        Logger $logger
    ) {
        $this->bannerFactory    = $bannerFactory;
        $this->resourceBanner   = $resourceBanner;
        $this->bannerCollection = $bannerCollection->create();
        $this->_logger          = $logger;
    }

    /**
     * @inheritdoc
     */
    public function save(\Redstage\Banner\Api\Data\BannerInterface $banner, $saveOptions = false)
    {
        $this->_logger->info(__METHOD__);

        try {

            $this->_logger->info('before getData');

            $data = $banner->getData();

            $banner->setData($data);

            $this->resourceBanner->save($banner);

        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $banner;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $this->_logger->info(__METHOD__);

        $this->_logger->info('id: '.$id);

        $banner = $this->bannerFactory->create();

        if (!empty($id) ) {
            if (isset($this->loadedBanners[$id])) {
                return $this->loadedBanners[$id];
            }

            $this->resourceBanner->load($banner, $id);
            if (!$banner->getId()) {
                throw new NoSuchEntityException(__('Banner with id "%1" does not exist.', $id));
            }
        }

        $this->_logger->info('before returning banner');

        return $banner;
    }

    /**
     * @inheritDoc
     */
    public function delete(\Redstage\Banner\Api\Data\BannerInterface $banner)
    {
        try {
            $this->resourceBanner->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        return $this->delete($this->get($id));
    }

    /**
     * @inheritDoc
     */
    public function getAll($forceReload = false)
    {
        if (empty($this->loadedBanners) || $forceReload)
        {
            $banners = $this->bannerCollection->load();
            $loadedBanners = [];
            foreach ($banners as $banner) {
                $loadedBanners[$banner->getId()] = $banner;
            }
            $this->loadedBanners = $loadedBanners;
        }

        return $this->loadedBanners;
    }
}