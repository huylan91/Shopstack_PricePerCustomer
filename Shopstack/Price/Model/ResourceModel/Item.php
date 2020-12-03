<?php

namespace Shopstack\Price\Model\ResourceModel;

class Item extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Set main entity table name and primary key field name
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ss_price', 'price_id');
    }
}
