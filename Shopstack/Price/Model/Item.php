<?php

namespace Shopstack\Price\Model;

class Item extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Shopstack\Price\Model\ResourceModel\Item');
	}
}
