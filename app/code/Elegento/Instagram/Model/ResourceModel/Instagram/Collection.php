<?php

namespace Elegento\Instagram\Model\ResourceModel\Instagram;

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
}