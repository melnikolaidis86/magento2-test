<?php

namespace Elegento\Instagram\Model\ResourceModel\Instagram;

use Elegento\Instagram\Api\Data\InstagramInterface;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Elegento\Instagram\Model\Instagram::class,
            \Elegento\Instagram\Model\ResourceModel\Instagram::class
        );
    }

    /**
     * @return $this
     */
    protected function _beforeLoad()
    {
        $this->setOrder(InstagramInterface::CREATED_AT, 'DESC');

        return parent::_beforeLoad();
    }
}