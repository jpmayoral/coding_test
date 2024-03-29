<?php

namespace Redstage\Banner\Controller\Adminhtml\Banner;

class Add extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;
    /**
     * @param \Magento\Backend\App\Action\Context               $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ){
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }
    /**
     * Create new Image
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
         * @var \Magento\Framework\Controller\Result\Forward $resultForward
         */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}