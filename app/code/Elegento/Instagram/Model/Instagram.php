<?php

namespace Elegento\Instagram\Model;

use Elegento\Instagram\Api\Data\InstagramInterface;
use Elegento\Instagram\Api\Data\InstagramInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class Instagram extends \Magento\Framework\Model\AbstractModel
{

    protected $instagramDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'elegento_instagram_instagram';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param InstagramInterfaceFactory $instagramDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Elegento\Instagram\Model\ResourceModel\Instagram $resource
     * @param \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        InstagramInterfaceFactory $instagramDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Elegento\Instagram\Model\ResourceModel\Instagram $resource,
        \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $resourceCollection,
        array $data = []
    ) {
        $this->instagramDataFactory = $instagramDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve instagram model with instagram data
     * @return InstagramInterface
     */
    public function getDataModel()
    {
        $instagramData = $this->getData();

        /** @var InstagramInterface $instagramDataObject */
        $instagramDataObject = $this->instagramDataFactory->create();

        $this->dataObjectHelper->populateWithArray(
            $instagramDataObject,
            $instagramData,
            InstagramInterface::class
        );

        return $instagramDataObject;
    }
}