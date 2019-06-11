<?php

namespace Redstage\Banner\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;


class ManageBannerActions
    extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Edit shipping configuration route.
     */
    const ROUTE_EDIT = 'redstage_banner/banner/edit';
    const ROUTE_DELETE = 'redstage_banner/banner/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor class
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritdoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href'   => $this->urlBuilder->getUrl(self::ROUTE_EDIT, ['banner_id' => $item['banner_id']]),
                    'label'  => __('Edit'),
                    'hidden' => false,
                ];

                $item[$this->getData('name')]['delete'] = [
                    'href'   => $this->urlBuilder->getUrl(self::ROUTE_DELETE, ['banner_id' => $item['banner_id']]),
                    'label'  => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete "${ $.$data.name }"'),
                        'message' => __('Are you sure you wan\'t to delete the "${ $.$data.name }" banner?')
                    ],
                    'hidden' => false,
                ];

            }
        }

        return $dataSource;
    }
}