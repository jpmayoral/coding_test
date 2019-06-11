<?php

namespace Redstage\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'banner_id';
	protected $_eventPrefix = 'redstage_banner_collection';
	protected $_eventObject = 'banner_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Redstage\Banner\Model\Banner', 'Redstage\Banner\Model\ResourceModel\Banner');
	}

}