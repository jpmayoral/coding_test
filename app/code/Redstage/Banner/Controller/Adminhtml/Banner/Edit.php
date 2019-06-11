<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Redstage\Banner\Controller\Adminhtml\Banner;

use Redstage\Banner\Logger\Logger;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Redstage_Banner::banner';

    /**
     * @var \Magento\Framework\Registry $registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Redstage\Banner\Api\BannerRepositoryInterface $bannerRepository
     */
    private $bannerRepository;

    protected $logger;

    /**
     * Edit constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\Session $session
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Search\Controller\Adminhtml\Synonyms\ResultPageBuilder $pageBuilder
     * @param \Redstage\Banner\Api\BannerRepositoryInterface $bannerRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Redstage\Banner\Api\BannerRepositoryInterface $bannerRepository,
        Logger $logger
    ) {
        $this->registry = $registry;
        $this->bannerRepository = $bannerRepository;
        $this->pageBuilder = $resultPageFactory;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Edit Synonym Group
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $this->logger->info(__METHOD__);

        // 1. Get ID and create model
        $bannerId = $this->getRequest()->getParam('banner_id');

        $this->logger->info('bannerId: '.$bannerId);

        /** @var \Magento\Search\Api\Data\SynonymGroupInterface $bannerModel */
        $bannerModel = $this->bannerRepository->get($bannerId);

        $this->logger->info('llega');

        // 2. Initial checking
        if ($bannerId && (!$bannerModel->getId())) {
            $this->messageManager->addError(__('This banner no longer exists.'));
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('redstage_banner/banner/');
        }

        // 3. Set entered data if was error when we do save
        $data = $this->_session->getFormData(true);

        $this->logger->info('Banner Name: '.$bannerModel->getName());
        $this->logger->info('Banner Content: '.$bannerModel->getContent());
        $this->logger->info('Banner Status: '.$bannerModel->getStatus());

        if (!empty($data)) {
            /*$bannerModel->setGroupId($data['group_id']);
            $bannerModel->setStoreId($data['store_id']);
            $bannerModel->setWebsiteId($data['website_id']);
            $bannerModel->setSynonymGroup($data['synonyms']);*/
        }

        // 4. Register model to use later in save
        $this->registry->register(
            'banner_model_data',
            $bannerModel
        );

        // 5. Build edit synonyms group form
        $resultPage = $this->pageBuilder->create();

        $resultPage->addBreadcrumb(
            $bannerId ? __('Edit Banner') : __('New Banner'),
            $bannerId ? __('Edit Banner') : __('New Banner')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Banners'));
        $resultPage->getConfig()->getTitle()->prepend(
            $bannerModel->getId() ? $bannerModel->getName() : __('New Banner')
        );
        return $resultPage;
    }
}