<?php

namespace Elegento\Instagram\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Instagram extends Template implements BlockInterface
{
    protected $_template = "widget/instagram.phtml";
    protected $_instagramData;

    /**
     * @var \Elegento\Instagram\Helper\Instagram
     */
    protected $instagramHelper;

    /**
     * @var \Elegento\Instagram\Model\ResourceModel\Instagram\Collection
     */
    protected $instagramCollectionFactory;

    /**
     * Instagram constructor.
     * @param Template\Context $context
     * @param \Elegento\Instagram\Model\ResourceModel\Instagram\CollectionFactory $instagramCollectionFactory
     * @param \Elegento\Instagram\Helper\Instagram $instagramHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Elegento\Instagram\Model\ResourceModel\Instagram\CollectionFactory $instagramCollectionFactory,
        \Elegento\Instagram\Helper\Instagram $instagramHelper,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->instagramCollectionFactory = $instagramCollectionFactory;
        $this->instagramHelper = $instagramHelper;
        $this->_instagramData =  $this->instagramHelper->getLatestMedia();
    }

    /**
     * @return \Elegento\Instagram\Model\ResourceModel\Instagram\Collection
     */
    public function getInstagramCollection()
    {
        /** @var \Elegento\Instagram\Model\ResourceModel\Instagram\Collection $instagramCollection */
        $instagramCollection = $this->instagramCollectionFactory->create();

        $instagramCollection->setPageSize(\Elegento\Instagram\Helper\Instagram::IMAGE_COUNT) // only get images that is going to be displayed
            ->setCurPage(1);

        return $instagramCollection;
    }
}