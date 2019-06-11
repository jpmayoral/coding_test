<?php 

namespace Redstage\Banner\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Layer\Resolver;
use Redstage\Banner\Helper\Data as bannerHelperData;

class Banner extends Template{

    public $helperData;
    public $layerResolver;

    public function __construct(
        Template\Context $context,
        Resolver $layerResolver,
        bannerHelperData $helperData
        )
	{
        parent::__construct($context);
        $this->layerResolver    = $layerResolver;
        $this->helperData       = $helperData;
    }
    
    public function sayHello()
	{
		return __('Hello World');
    }
    
    public function getCurrentCategory()
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }

    public function getCurrentCategoryId()
    {
        return $this->getCurrentCategory()->getId();
    }

    /**
     * @return array|AbstractCollection
     */
    public function getCategoryBanner($categoryId = null)
    {
        $collection = [];
        $collection = $this->helperData->getCategoryBannerCollection();

        return $collection;
    }

    /**
     * @return array|AbstractCollection
     */
    public function getProductBanner($productId = null)
    {
        $collection = [];
        $collection = $this->helperData->getProductBannerCollection();

        return $collection;
    }

}

