<?php

namespace Redstage\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Model\Block;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Redstage\Banner\Logger\Logger;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Redstage\Banner\Api\BannerRepositoryInterface
     */
    protected $_bannerRepository;

    protected $_logger;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        \Redstage\Banner\Api\BannerRepositoryInterface $bannerRepository,
        Logger $logger
    ) {
        $this->dataPersistor        = $dataPersistor;
        $this->_coreRegistry        = $coreRegistry;
        $this->_bannerRepository    = $bannerRepository;
        $this->_logger              = $logger;

        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_logger->info(__METHOD__);

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        $this->_logger->info('data: '.print_r($data,true));

        if ($data) {
            $id = $this->getRequest()->getParam('banner_id');

            if (empty($id)) {
                $data['banner_id'] = null;
            }

            /** @var \Redstage\Banner\Model\Banner $model */
            $model = $this->_bannerRepository->get($id);
            $model->setData($data);

            $this->_logger->info('before try');

            try {
                $this->_bannerRepository->save($model);

                $this->_logger->info('after save model');

                $this->messageManager->addSuccessMessage(__('You saved the block.'));
                $this->dataPersistor->clear('redstage_banner');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('redstage_banner/banner/edit', ['banner_id' => $model->getId()]);
                }

                return $resultRedirect->setPath('redstage_banner/banner/');

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('redstage_banner', $data);
            return $resultRedirect->setPath('redstage_banner/banner/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('redstage_banner/banner/');
    }
}