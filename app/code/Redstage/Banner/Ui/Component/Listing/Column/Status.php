<?php

namespace Redstage\Banner\Ui\Component\Listing\Column;

class Status extends \Magento\Ui\Component\Listing\Columns\Column {

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as & $item) {

                if($item['status']){
                    $item['status'] = 'Enabled';
                }else{
                    $item['status'] = 'Disabled';
                }

            }
        }

        return $dataSource;
    }
}
