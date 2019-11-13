<?php

namespace Elegento\Instagram\Model\ResourceModel;

use Elegento\Instagram\Api\Data\InstagramInterface;

class Instagram extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(InstagramInterface::TABLE_NAME, InstagramInterface::INSTAGRAM_ID);
    }
}